<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function showcart(Request $request)
    {
        $cart = $this->resolveCart($request);
        $cart->load('items.producto');

        $items = $cart->items->map(function (CarritoItem $item) {
            $producto = $item->producto;

            return [
                'id' => $item->id,
                'producto_id' => $item->producto_id,
                'nombre' => $producto->nombre_producto ?? 'Producto',
                'descripcion' => $producto->descripcion ?? '',
                'imagen' => $producto->imagen_producto ?? null,
                'precio' => (float) $item->precio_unitario,
                'cantidad' => (int) $item->cantidad,
                'subtotal' => (float) $item->subtotal,
            ];
        })->values();

        return view('carrito.detallecarrito', [
            'carrito' => $cart,
            'cartItems' => $items,
        ]);
    }

    public function addacart(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'producto_id' => ['required', 'integer', 'exists:productos,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $producto = Producto::activos()->findOrFail($payload['producto_id']);

        try {
            DB::transaction(function () use ($request, $producto, $payload) {
                $cart = $this->resolveCart($request);

                $item = $cart->items()->where('producto_id', $producto->id)->lockForUpdate()->first();
                $cantidadActual = $item?->cantidad ?? 0;
                $cantidadSolicitada = $payload['cantidad'];
                $nuevaCantidad = $cantidadActual + $cantidadSolicitada;

                if (!is_null($producto->stock) && $nuevaCantidad > $producto->stock) {
                    throw ValidationException::withMessages([
                        'cantidad' => 'No hay stock suficiente para completar esta solicitud.',
                    ]);
                }

                $precioUnitario = (float) ($producto->precio ?? 0);

                if ($item) {
                    $item->update([
                        'cantidad' => $nuevaCantidad,
                        'precio_unitario' => $precioUnitario,
                        'subtotal' => $nuevaCantidad * $precioUnitario,
                    ]);
                } else {
                    $cart->items()->create([
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidadSolicitada,
                        'precio_unitario' => $precioUnitario,
                        'subtotal' => $cantidadSolicitada * $precioUnitario,
                    ]);
                }

                $this->recalculateTotals($cart);
            });
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors([
                'general' => 'No se pudo actualizar el carrito. Intenta mas tarde.',
            ]);
        }

        return redirect()
            ->route('carrito.detalle')
            ->with('status', 'Producto anadido al carrito.');
    }

    public function update(Request $request, CarritoItem $item): RedirectResponse
    {
        $cart = $this->resolveCart($request);

        abort_if($item->carrito_id !== $cart->id, 403);

        $payload = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $producto = Producto::activos()->findOrFail($item->producto_id);
        $cantidad = $payload['cantidad'];

        if (!is_null($producto->stock) && $cantidad > $producto->stock) {
            return back()->withErrors([
                'cantidad' => 'No hay stock suficiente para completar esta solicitud.',
            ]);
        }

        $precioUnitario = (float) ($producto->precio ?? $item->precio_unitario);

        DB::transaction(function () use ($item, $cart, $cantidad, $precioUnitario) {
            $item->update([
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $cantidad * $precioUnitario,
            ]);

            $this->recalculateTotals($cart);
        });

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function destroy(Request $request, CarritoItem $item): RedirectResponse
    {
        $cart = $this->resolveCart($request);

        abort_if($item->carrito_id !== $cart->id, 403);

        DB::transaction(function () use ($item, $cart) {
            $item->delete();
            $this->recalculateTotals($cart);
        });

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    protected function resolveCart(Request $request): Carrito
    {
        $cliente = Auth::guard('clientes')->user();
        $sessionToken = $request->session()->get('cart.token');

        if (!$sessionToken) {
            $sessionToken = (string) Str::uuid();
            $request->session()->put('cart.token', $sessionToken);
        }

        if ($cliente) {
            $cart = Carrito::activo()->firstOrCreate(
                ['cliente_id' => $cliente->id, 'estado' => 'abierto'],
                [
                    'session_token' => $sessionToken,
                    'total_items' => 0,
                    'total' => 0,
                ]
            );

            $guestCart = Carrito::activo()
                ->whereNull('cliente_id')
                ->where('session_token', $sessionToken)
                ->where('id', '!=', $cart->id)
                ->with('items')
                ->first();

            if ($guestCart) {
                $this->mergeCarts($cart, $guestCart);
                $guestCart->delete();
            }

            if (!$cart->session_token) {
                $cart->session_token = $sessionToken;
                $cart->save();
            }

            return $cart;
        }

        return Carrito::activo()->firstOrCreate(
            ['session_token' => $sessionToken, 'estado' => 'abierto'],
            [
                'total_items' => 0,
                'total' => 0,
            ]
        );
    }

    protected function mergeCarts(Carrito $target, Carrito $source): void
    {
        $source->loadMissing('items');

        foreach ($source->items as $item) {
            $existing = $target->items()->where('producto_id', $item->producto_id)->first();

            if ($existing) {
                $cantidad = $existing->cantidad + $item->cantidad;
                $precioUnitario = $item->precio_unitario;
                $existing->update([
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $cantidad * $precioUnitario,
                ]);
            } else {
                $target->items()->create([
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->subtotal,
                ]);
            }
        }

        $this->recalculateTotals($target->fresh('items'));
    }

    protected function recalculateTotals(Carrito $cart): void
    {
        $cart->loadMissing('items');

        $totalItems = $cart->items->sum('cantidad');
        $total = $cart->items->sum('subtotal');

        $cart->forceFill([
            'total_items' => $totalItems,
            'total' => $total,
        ])->save();
    }
}
