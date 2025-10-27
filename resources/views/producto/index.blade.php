@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col">
            <h2>Productos activos</h2>
        </div>
    </div>

    @if($productos->isEmpty())
        <div class="alert alert-info">
            No hay productos activos registrados.
        </div>
    @else
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Categoría</th>
                                <th>Proveedor</th>
                                <th>Imagen</th>
                                <th>Video</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre_producto }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td>{{ $producto->stock }}</td>
                                    <td>{{ ucfirst($producto->estado_producto) }}</td>
                                    <td>{{ $producto->categoria_id }}</td>
                                    <td>{{ $producto->proveedor_id }}</td>
                                    <td>
                                        @if($producto->imagen_producto)
                                            <img src="{{ asset('images/' . $producto->imagen_producto) }}" alt="Imagen de {{ $producto->nombre_producto }}" style="max-width: 80px;">
                                        @else
                                            <span class="text-muted">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($producto->video_producto)
                                            <a href="{{ asset('videos/' . $producto->video_producto) }}" target="_blank">Ver video</a>
                                        @else
                                            <span class="text-muted">Sin video</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
