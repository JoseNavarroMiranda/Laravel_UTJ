<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = Categoria::select('id', 'nombre_categoria', 'descripcion', 'estado_categoria')
            ->orderBy('nombre_categoria')
            ->get();
        return view('categoria.index', ['categorias' => $this->cargarDT($categoria)]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre_categoria' => 'required',
            'descripcion' => 'nullable',
                ]);
        #creacioon de a categoria
        $categoria = new Categoria();
        $categoria->nombre_categoria = $request->input('nombre_categoria');
        $categoria->descripcion = $request->input('descripcion');
        $categoria->save();
        return redirect()->route('categoria.create')->with('success', 'Categoría creada exitosamente.');
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
        $categoria = Categoria::findorFail($id);
        return view('categoria.edit', array(
            'categoria' => $categoria
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre_categoria' => 'required',
            'descripcion' => 'nullable',
            'estado_categoria' => 'required',
        ]);
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre_categoria = $request->input('nombre_categoria');
        $categoria->descripcion = $request->input('descripcion');
        $categoria->estado_categoria = $request->input('estado_categoria');
        $categoria->save();
        return redirect()->route('categoria.edit',$id)->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deteleCategoria(string $id)
    {
        $categoria = Categoria::findorFail($id);
        $categoria->delete();
        return redirect()->route('categoria.index')->with('success', 'Categoria elimina correctamente');
    }

    private function cargarDT($data)
    {
        $dataTable = [];
        foreach ($data as $item) {
            $acciones = '<a href="' . route('categoria.edit', $item->id) . '" class="btn btn-primary btn-sm">Editar</a>';
            $dataTable[] = [
                'id' => $item->id,
                'nombre_categoria' => $item->nombre_categoria,
                'descripcion' => $item->descripcion,
                'estado_categoria' => $item->estado_categoria,
                'acciones' => $acciones,
            ];
        }
        return $dataTable;
    }
}
