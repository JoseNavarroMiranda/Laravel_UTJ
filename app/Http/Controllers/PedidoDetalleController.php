<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Pedido_Detalle;
use App\Models\Producto;

class PedidoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detalles = Pedido_Detalle::with(['pedido.cliente', 'producto'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        return view('pedido_detalle.index', [
            'detalles' => $this->cargarDT($detalles),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pedidos = Pedido::select('id', 'fecha_pedido')
            ->orderByDesc('fecha_pedido')
            ->get();
        $productos = Producto::select('id', 'nombre_producto')
            ->orderBy('nombre_producto')
            ->get();

        return view('pedido_detalle.create', [
            'pedidos' => $pedidos,
            'productos' => $productos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
        ]);
        // logica para guardar el detalle del pedido en la base de datos
        Pedido_Detalle::create($payload);

        return redirect()->route('pedido_detalle.create')->with('success', 'Detalle del pedido creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pedidoDetalle = Pedido_Detalle::with(['pedido', 'producto'])->findOrFail($id);
        $pedidos = Pedido::select('id', 'fecha_pedido')
            ->orderByDesc('fecha_pedido')
            ->get();
        $productos = Producto::select('id', 'nombre_producto')
            ->orderBy('nombre_producto')
            ->get();

        return view('pedido_detalle.edit', [
            'pedido_detalle' => $pedidoDetalle,
            'pedidos' => $pedidos,
            'productos' => $productos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $payload = $this->validate($request, [
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
        ]);
        $pedidoDetalle = Pedido_Detalle::findOrFail($id);
        $pedidoDetalle->update($payload);

        return redirect()->route('pedido_detalle.edit', $id)->with('success', 'Detalle del pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deletePedidoDetalle(string $id)
    {
        $pedidoDetalle = Pedido_Detalle::findOrFail($id);
        $pedidoDetalle->delete();

        return redirect()->route('pedido_detalle.index')->with('success', 'Detalle del pedido eliminado exitosamente.');
    }

    private function cargarDT($data)
    {
        $dataTable = [];

        foreach ($data as $item) {
            $editUrl = route('pedido_detalle.edit', $item->id);
            $deleteUrl = route('pedido_detalle.delete', ['pedido_detalle' => $item->id]);

            $acciones = '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">Editar</a>';
            $acciones .= '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#pedidoDetalleConfirmDelete" data-pedido-detalle-id="' . $item->id . '" data-pedido-detalle-delete="' . $deleteUrl . '" data-pedido-detalle-label="Pedido #' . $item->pedido_id . '">Eliminar</button>';

            $dataTable[] = [
                'acciones' => $acciones,
                'id' => $item->id,
                'pedido' => $item->pedido_id,
                'cliente' => optional(optional($item->pedido)->cliente)->nombre ?? 'Invitado',
                'producto' => optional($item->producto)->nombre_producto ?? 'Producto',
                'cantidad' => $item->cantidad,
                'precio_unitario' => number_format((float) ($item->precio_unitario ?? 0), 2, '.', ''),
                'subtotal' => number_format((float) ($item->subtotal ?? 0), 2, '.', ''),
            ];
        }

        return $dataTable;
    }
}
