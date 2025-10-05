<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido_Detalle;

class PedidoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pedido_detalle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
        ]);
        // logica para guardar el detalle del pedido en la base de datos
        $PedidoDetalle = new Pedido_Detalle();
        $PedidoDetalle->cantidad = $request->cantidad;
        $PedidoDetalle->precio_unitario = $request->precio_unitario;
        $PedidoDetalle->subtotal = $request->subtotal;
        $PedidoDetalle->pedido_id = $request->pedido_id;
        $PedidoDetalle->producto_id = $request->producto_id;
        $PedidoDetalle->save();
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
        $PedidoDetalle = Pedido_Detalle::findOrFail($id);
        return view('pedido_detalle.edit', array(
            'pedido_detalle' => $PedidoDetalle
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $this->validate($request, [
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
        ]);
        $PedidoDetalle = Pedido_Detalle::findOrFail($id);
        $PedidoDetalle->cantidad = $request->input('cantidad');
        $PedidoDetalle->precio_unitario = $request->input('precio_unitario');
        $PedidoDetalle->subtotal = $request->input('subtotal');
        $PedidoDetalle->pedido_id = $request->input('pedido_id');
        $PedidoDetalle->producto_id = $request->input('producto_id');
        $PedidoDetalle->save();
        return redirect()->route('pedido_detalle.edit', $id)->with('success', 'Detalle del pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
