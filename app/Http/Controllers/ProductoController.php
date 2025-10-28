<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::select(
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
            ->with('imagenes')
            ->orderBy('nombre_producto')
            ->get();

        return view('producto.index', ['productos' => $this->cargarDT($productos)]);
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
        $validated = $request->validate([
            'nombre_producto' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen_producto' => 'required|array|min:1',
            'imagen_producto.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'video_producto' => 'required|file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm',
            'categoria_id' => 'required',
            'proveedor_id' => 'required',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $producto = new Producto();
            $producto->nombre_producto = $validated['nombre_producto'];
            $producto->descripcion = $validated['descripcion'];
            $producto->precio = $validated['precio'];
            $producto->stock = $validated['stock'];
            $producto->categoria_id = $validated['categoria_id'];
            $producto->proveedor_id = $validated['proveedor_id'];

            $imagenesArchivos = collect($request->file('imagen_producto', []))->filter()->values();
            $principalRuta = null;

            if ($imagenesArchivos->isNotEmpty()) {
                $principalRuta = $this->guardarArchivo($imagenesArchivos->shift(), 'images');
                $producto->imagen_producto = $principalRuta;
            }

            if ($request->hasFile('video_producto')) {
                $videoFile = $request->file('video_producto');
                $producto->video_producto = $this->guardarArchivo($videoFile, 'videos');
            }

            $producto->save();

            if ($principalRuta) {
                $producto->imagenes()->create(['ruta' => $principalRuta]);
            }

            if ($imagenesArchivos->isNotEmpty()) {
                $this->agregarImagenes($producto, $imagenesArchivos->all());
            }
        });

        return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->loadMissing('imagenes');

        return view('productosdash.producto', [
            'producto' => $producto,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::with('imagenes')->findOrFail($id);

        return view('producto.edit', [
            'Producto' => $producto,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre_producto' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'estado_producto' => 'required',
            'imagen_producto' => 'nullable|array',
            'imagen_producto.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'video_producto' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml,video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm',
            'categoria_id' => 'required',
            'proveedor_id' => 'required',
        ]);

        $producto = Producto::findOrFail($id);

        DB::transaction(function () use ($producto, $request, $validated) {
            $producto->nombre_producto = $validated['nombre_producto'];
            $producto->descripcion = $validated['descripcion'];
            $producto->precio = $validated['precio'];
            $producto->stock = $validated['stock'];
            $producto->estado_producto = $validated['estado_producto'];
            $producto->categoria_id = $validated['categoria_id'];
            $producto->proveedor_id = $validated['proveedor_id'];

            if ($request->hasFile('video_producto')) {
                $videoFile = $request->file('video_producto');
                $producto->video_producto = $this->guardarArchivo($videoFile, 'videos');
            }

            $producto->save();

            if ($request->hasFile('imagen_producto')) {
                $this->agregarImagenes($producto, $request->file('imagen_producto', []), true);
            }
        });

        return redirect()->route('producto.create', $id)->with('success', 'se ah actualiza el producto de manera correcta');
    }

    private function cargarDT($data)
    {
        $dataTable = [];

        foreach ($data as $item) {
            $acciones = '<a href="' . route('producto.edit', $item->id) . '" class="btn btn-primary btn-sm">Editar</a>';
            $dataTable[] = [
                'id' => $item->id,
                'nombre_producto' => $item->nombre_producto,
                'descripcion' => $item->descripcion,
                'precio' => $item->precio,
                'stock' => $item->stock,
                'estado_producto' => $item->estado_producto,
                'imagen_producto' => $item->imagen_producto,
                'imagenes' => $item->imagenes->pluck('ruta')->all(),
                'video_producto' => $item->video_producto,
                'categoria_id' => $item->categoria_id,
                'proveedor_id' => $item->proveedor_id,
                'acciones' => $acciones,
            ];
        }
        return $dataTable;
    }


    private function agregarImagenes(Producto $producto, array $imagenes = [], bool $reemplazarPrincipal = false): void
    {
        $imagenesCollection = collect($imagenes)->filter();

        if ($imagenesCollection->isEmpty()) {
            return;
        }

        $imagenPrincipal = $imagenesCollection->shift();

        if ($imagenPrincipal) {
            $rutaPrincipal = $this->guardarArchivo($imagenPrincipal, 'images');

            if ($reemplazarPrincipal || empty($producto->imagen_producto)) {
                $producto->imagen_producto = $rutaPrincipal;
                $producto->save();
            }

            $producto->imagenes()->create(['ruta' => $rutaPrincipal]);
        }

        $imagenesCollection->each(function ($imagen) use ($producto) {
            $ruta = $this->guardarArchivo($imagen, 'images');
            $producto->imagenes()->create(['ruta' => $ruta]);
        });
    }

    private function guardarArchivo($archivo, string $directorio): string
    {
        $destino = public_path($directorio);

        if (!is_dir($destino)) {
            mkdir($destino, 0755, true);
        }

        $extension = strtolower($archivo->getClientOriginalExtension() ?: $archivo->extension());
        $nombre = uniqid($directorio . '_', true) . '.' . $extension;

        $archivo->move($destino, $nombre);

        return $nombre;
    }








    /**
     * Remove the specified resource from storage.
     */
    public function deleteProducto(string $id)
    {
        $producto = Producto::findOrFail($id);
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
        $producto->loadMissing('imagenes');

        return view('productosdash.producto', [
            'producto' => $producto
        ]);

    }


}
