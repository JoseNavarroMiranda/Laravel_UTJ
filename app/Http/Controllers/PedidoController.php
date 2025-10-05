<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Pedido;

class PedidoController extends Controller
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
        return view('pedido.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_pedido' => 'required|date',
            'estado_pedido' => 'required|string',
            'metodo_pago' => 'required|string',
            'total' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
        ]);
        $Pediod = new Pedido();
        $Pediod->fecha_pedido = $request->fecha_pedido;
        $Pediod->estado_pedido = $request->estado_pedido;
        $Pediod->metodo_pago = $request->metodo_pago;
        $Pediod->total = $request->total;
        $Pediod->cliente_id = $request->cliente_id;
        $Pediod->save();
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
        $pedido = Pedido::findorFail($id);
        return view('pedido.edit', array(
            'pedido' => $pedido
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate ($request, [
            'fecha_pedido' => 'required|date',
            'estado_pedido' => 'required|string',
            'metodo_pago' => 'required|string',
            'total' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
        ]);
        $pedido = Pedido::findorFail($id);
        $pedido->fecha_pedido = $request->input('fecha_pedido');
        $pedido->estado_pedido = $request->input('estado_pedido');
        $pedido->metodo_pago = $request->input('metodo_pago');
        $pedido->total = $request->input('total');
        $pedido->cliente_id = $request->input('cliente_id');
        $pedido->save();
        return redirect()->route('pedido.edit', $id)->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
