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
        $productos = Producto::activos()
            ->select(
                'id',
                'nombre_producto',
                'descripcion',
                'precio',
                'stock',
                'imagen_producto',
                'video_producto',
                'estado_producto',
                'categoria_id',
                'proveedor_id'
            )
            ->orderBy('nombre_producto')
            ->get();

        return view('producto.index', compact('productos'));
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
    public function show(Producto $producto)
    {
        return view('productosdash.producto', [
            'producto' => $producto,
        ]);
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
        }
        if ($request->hasFile('video_producto')) {
            $videoName = time().'.'.$request->video_producto->extension();  
            $request->video_producto->move(public_path('videos'), $videoName);
            $Producto->video_producto = $videoName;
        }
        $Producto->categoria_id = $request->input('categoria_id');
        $Producto->proveedor_id = $request->input('proveedor_id');
        $Producto->save();
        return redirect()->route('producto.create', $id)->with('success', 'se ah actualiza el producto de manera correcta');
    
    }

    private function cargarDT(){

        $dataTable = [];
        foreach ($data as $item) {
            $acciones = '<a href="' . route('producto.edit', $item->id) . '" class="btn btn-primary btn-sm">Editar</a>';
            $dataTable[] = [
                'id' => $item->id,
                'nomnombre_productobre' => $item->nombre_producto,
                'descripcion' => $item->descripcion,
                'precio' => $item->precio,
                'stock' => $item->stock,
                'estado_producto' => $item->estado_producto,
                'imagen_producto' => $item->imagen_producto,
                'video_producto' => $item->video_producto,
                'categoria_id' => $item->categoria_id,
                'proveedor_id' => $item->proveedor_id,
                'acciones' => $acciones,
            ];
        }
        return $dataTable;

    }








    /**
     * Remove the specified resource from storage.
     */
    public function deleteProducto(string $id)
    {
        $producto = Producto::findorFail($id);
        $producto->delete();
        return redirect()->route('producto.index')->with('success', 'Producto eliminado exitosamente.');


    }


    #Funciones que se utilizaran para el ecommerce de proyecto

    public function indexProductos()
    {
        $Productos = Producto::activos()
            ->select('id','nombre_producto','descripcion','precio','stock',)
            ->orderBy('nombre_producto')
            ->get();
        return view('pruductosdash.productos', compact('productos'));
    
    }

    #funcion para mostrar tarjeta de producto
    public function showProducto(Producto $producto){
        return view('productosdash.producto', [
            'producto' => $producto
        ]);

    }


}
