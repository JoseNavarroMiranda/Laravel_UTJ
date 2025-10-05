<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Producto;

class ProductoController extends Controller
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
        return view('producto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen_producto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'video_producto' => 'required|file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm',
            'categoria_id' => 'required',
            'proveedor_id' => 'required',
        ]);
        // logica para guardar el producto en la base de datos
        $Producto = new Producto();
        $Producto->nombre_producto = $request->nombre_producto;
        $Producto->descripcion = $request->descripcion;
        $Producto->precio = $request->precio;
        $Producto->stock = $request->stock;
        if ($request->hasFile('imagen_producto')) {
            $imageName = time().'.'.$request->imagen_producto->extension();  
            $request->imagen_producto->move(public_path('images'), $imageName);
            $Producto->imagen_producto = $imageName;
        }
        if ($request->hasFile('video_producto')) {
            $videoName = time().'.'.$request->video_producto->extension();  
            $request->video_producto->move(public_path('videos'), $videoName);
            $Producto->video_producto = $videoName;
        }
        $Producto->categoria_id = $request->categoria_id;
        $Producto->proveedor_id = $request->proveedor_id;
        $Producto->save();
        return redirect()->route('producto.create')->with('success', 'Producto creado exitosamente');
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
        $Producto = Producto::findorFail($id);
        return view('producto.edit',  array(
            'Producto' => $Producto
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombre_producto' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'estado_producto' => 'required',
            'imagen_producto' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'video_producto' => 'file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm',
            'categoria_id' => 'required',
            'proveedor_id' => 'required',
        ]);
        $Producto = Producto::findorFail($id);
        $Producto->nombre_producto = $request->input('nombre_producto');
        $Producto->descripcion = $request->input('descripcion');
        $Producto->precio = $request->input('precio');
        $Producto->stock = $request->input('stock');
        $Producto->estado_producto = $request->input('estado_producto');
        if ($request->hasFile('imagen_producto')) {
            $imageName = time().'.'.$request->imagen_producto->extension();  
            $request->imagen_producto->move(public_path('images'), $imageName);
            $Producto->imagen_producto = $imageName;
        if ($request->hasFile('video_producto')) {
            $videoName = time().'.'.$request->video_producto->extension();  
            $request->video_producto->move(public_path('videos'), $videoName);
            $Producto->video_producto = $videoName;
        }
        $Producto->categoria_id = $request->input('categoria_id');
        $Producto->proveedor_id = $request->input('proveedor_id');
        $Producto->save();
        return redirect()->route('producto.edit', $id)->with('success', 'se ah actualiza el producto de manera correcta');
    }
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
