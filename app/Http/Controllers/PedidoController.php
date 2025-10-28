<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Pedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with('cliente')
            ->withCount('detalles')
            ->orderByDesc('fecha_pedido')
            ->orderByDesc('id')
            ->get();

        return view('pedido.index', [
            'pedidos' => $this->cargarDT($pedidos),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::select('id', 'nombre', 'email')
            ->orderBy('nombre')
            ->get();

        return view('pedido.create', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'fecha_pedido' => 'required|date',
            'estado_pedido' => 'required|string',
            'metodo_pago' => 'required|string',
            'total' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        Pedido::create($payload);

        return redirect()->route('pedido.create')->with('success', 'Pedido creado exitosamente');
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
        $pedido = Pedido::with('cliente')->findOrFail($id);
        $clientes = Cliente::select('id', 'nombre', 'email')
            ->orderBy('nombre')
            ->get();

        return view('pedido.edit', [
            'pedido' => $pedido,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = $this->validate($request, [
            'fecha_pedido' => 'required|date',
            'estado_pedido' => 'required|string',
            'metodo_pago' => 'required|string',
            'total' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update($payload);

        return redirect()->route('pedido.edit', $id)->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deletePedido(string $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedido.index')->with('success', 'Pedido eliminado exitosamente.');
    }

    private function cargarDT($data)
    {
        $dataTable = [];

        foreach ($data as $item) {
            $editUrl = route('pedido.edit', $item->id);
            $deleteUrl = route('pedido.delete', ['pedido' => $item->id]);

            $acciones = '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1">Editar</a>';
            $acciones .= '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#pedidoConfirmDelete" data-pedido-id="' . $item->id . '" data-pedido-delete="' . $deleteUrl . '" data-pedido-label="' . e(optional($item->cliente)->nombre ?? 'Invitado') . '">Eliminar</button>';

            $fecha = optional($item->fecha_pedido)->format('Y-m-d');
            $total = number_format((float) ($item->total ?? 0), 2, '.', '');

            $dataTable[] = [
                'acciones' => $acciones,
                'id' => $item->id,
                'fecha' => $fecha,
                'estado' => $item->estado_pedido,
                'metodo_pago' => $item->metodo_pago,
                'total' => $total,
                'cliente' => optional($item->cliente)->nombre ?? 'Invitado',
                'detalles' => $item->detalles_count ?? 0,
            ];
        }

        return $dataTable;
    }
}
