@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h2>Editar producto</h2>
            <form action="{{ route('producto.update', $Producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="nombre_producto">Nombre</label>
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="{{ old('nombre_producto', $Producto->nombre_producto) }}" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $Producto->descripcion) }}" required>
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $Producto->precio) }}" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $Producto->stock) }}" required>
                </div>
                <div class="form-group">
                    <label for="categoria_id">Categoria</label>
                    <input type="number" class="form-control" id="categoria_id" name="categoria_id" value="{{ old('categoria_id', $Producto->categoria_id) }}" required>
                </div>
                <div class="form-group">
                    <label for="proveedor_id">Proveedor</label>
                    <input type="number" class="form-control" id="proveedor_id" name="proveedor_id" value="{{ old('proveedor_id', $Producto->proveedor_id) }}" required>
                </div>
                <div class="form-group">
                    <label for="estado_producto">Estado</label>
                    <select class="form-control" id="estado_producto" name="estado_producto" required>
                        <option value="activo" {{ old('estado_producto', $Producto->estado_producto) === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado_producto', $Producto->estado_producto) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="imagen_producto">Imagen del producto</label>
                    <input type="file" class="form-control" id="imagen_producto" name="imagen_producto">
                    @if($Producto->imagen_producto)
                        <small class="form-text text-muted">Actual: {{ $Producto->imagen_producto }}</small>
                    @endif
                </div>
                <div class="form-group">
                    <label for="video_producto">Video del producto</label>
                    <input type="file" class="form-control" id="video_producto" name="video_producto">
                    @if($Producto->video_producto)
                        <small class="form-text text-muted">Actual: {{ $Producto->video_producto }}</small>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Actualizar producto</button>
            </form>
        </div>
    </div>
</div>
@endsection
