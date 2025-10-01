<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class ClienteController extends Controller
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
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'domicilio' => 'required',
            'ciudad' => 'required',
            'cp' => 'required|digits:5',
            'telefono' => 'required|digits:10',
            'email' => 'required',
            'password' => 'required',
        ]);
        $cliente = new Cliente();
        $cliente->nombre = $request->input('nombre');
        $cliente->domicilio = $request->input('domicilio');
        $cliente->ciudad = $request->input('ciudad');
        $cliente->cp = $request->input('cp');
        $cliente->telefono = $request->input('telefono');
        $cliente->email = $request->input('email');
        $cliente->password = bcrypt($request->input('password'));
        $cliente->save();
        return redirect()->route('cliente.create')->with('success', 'Cliente creado exitosamente.');

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
        // esta funcion nos permitira realizar cambios en los datos del cliente, nos traera los datos del cliente y los mostrara en el formulario de edicion
        $cliente = Cliente::findorFail($id);
        return view('cliente.edit',  array(
            'cliente' => $cliente
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Guardaremos los cambios realizados en el formulario de edicion
        $this->validate($request, [
            'nombre' => 'required',
            'domicilio' => 'required',
            'ciudad' => 'required',
            'cp' => 'required|digits:5',
            'telefono' => 'required|digits:10',
            'email' => 'required',
        ]);
        $cliente = Cliente::findorFail($id);
        $cliente->nombre = $request->input('nombre');
        $cliente->domicilio = $request->input('domicilio');
        $cliente->ciudad = $request->input('ciudad');
        $cliente->cp = $request->input('cp');
        $cliente->telefono = $request->input('telefono');
        $cliente->email = $request->input('email');
        $cliente->password = bcrypt($request->input('password'));
        $cliente->save();
        return redirect() -> route('cliente.create')->with(array('message' => 'Cliente actualizado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
