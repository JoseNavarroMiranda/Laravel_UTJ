<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;    

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedors.create');

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
            'rfc' => 'required|size:13',
            'email' => 'required',
            'password' => 'required',
        ]);
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->input('nombre');
        $proveedor->domicilio = $request->input('domicilio');
        $proveedor->ciudad = $request->input('ciudad');
        $proveedor->cp = $request->input('cp');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->rfc = $request->input('rfc');
        $proveedor->email = $request->input('email');
        $proveedor->password = bcrypt($request->input('password'));
        $proveedor->save();
        return redirect()->route('proveedor.create')->with('success', 'Proveedor creado exitosamente');
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
        //Esta funcion nos permitira eidtar el perfil de proveedor, haciendo la busqueda por id
        $proveedor = Proveedor::findorFail($id);
        return view('proveedors.edit',  array(
            'proveedor' => $proveedor
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Guardamos los cambios realizados en el pefil de proveedor
        $this->validate($request, [
            'nombre' => 'required',
            'domicilio' => 'required',
            'ciudad' => 'required',
            'cp' => 'required|digits:5',
            'telefono' => 'required|digits:10',
            'rfc' => 'required|size:13',
            'email' => 'required',
        ]);
        $proveedor = Proveedor::findorFail($id);
        $proveedor->nombre = $request->input('nombre');
        $proveedor->domicilio = $request->input('domicilio');
        $proveedor->ciudad = $request->input('ciudad');
        $proveedor->cp = $request->input('cp');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->rfc = $request->input('rfc');
        $proveedor->email = $request->input('email');
        $proveedor->update();
        return redirect()->route('proveedor.edit', $id)->with('success', 'Perfil actualizado exitosamente.');       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
