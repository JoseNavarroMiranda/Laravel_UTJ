<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
   

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provedor = Proveedor::activos()
            ->select('id', 'nombre', 'domicilio', 'ciudad', 'cp', 'telefono', 'rfc', 'email', 'estado_proveedor')
            ->get();
        return view('proveedors.index', ['provedors' => $this->cargarDT($provedor)]);  

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
            'estado_proveedor' => 'required',
        ]);
        $proveedor = Proveedor::findorFail($id);
        $proveedor->nombre = $request->input('nombre');
        $proveedor->domicilio = $request->input('domicilio');
        $proveedor->ciudad = $request->input('ciudad');
        $proveedor->cp = $request->input('cp');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->rfc = $request->input('rfc');
        $proveedor->email = $request->input('email');
        $proveedor->estado_proveedor = $request->input('estado_proveedor');
        $proveedor->update();
        return redirect()->route('proveedor.edit', $id)->with('success', 'Proveedor actualizado exitosamente.');       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProveedor($id)
    {
        $proveedor = Proveedor::findorFail($id);
        $proveedor->delete();
        return redirect()->route('proveedor.index')->with('success', 'Proveedor eliminado exitosamente.');
    }

    private function cargarDT($data)
    {
        $dataTable = [];
        foreach ($data as $item) {
            $acciones = '<a href="' . route('proveedor.edit', $item->id) . '" class="btn btn-primary btn-sm">Editar</a>';
            $dataTable[] = [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'domicilio' => $item->domicilio,
                'ciudad' => $item->ciudad,
                'cp' => $item->cp,
                'telefono' => $item->telefono,
                'rfc' => $item->rfc,
                'email' => $item->email,
                'estado_proveedor' => $item->estado_proveedor,
                'acciones' => $acciones,
            ];
        }
        return $dataTable;
    }

}
