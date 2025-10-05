@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <h2>Editar detalle de pedido</h2>
            <form action="{{ route('pedido_detalle.update', $pedido_detalle->id) }}" method="POST" class="mt-3">
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
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad', $pedido_detalle->cantidad) }}" required>
                </div>
                <div class="form-group">
                    <label for="precio_unitario">Precio unitario</label>
                    <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" step="0.01" min="0" value="{{ old('precio_unitario', $pedido_detalle->precio_unitario) }}" required>
                </div>
                <div class="form-group">
                    <label for="subtotal">Subtotal</label>
                    <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" min="0" value="{{ old('subtotal', $pedido_detalle->subtotal) }}" required>
                </div>
                <div class="form-group">
                    <label for="pedido_id">Pedido</label>
                    <input type="number" class="form-control" id="pedido_id" name="pedido_id" min="1" value="{{ old('pedido_id', $pedido_detalle->pedido_id) }}" required>
                </div>
                <div class="form-group">
                    <label for="producto_id">Producto</label>
                    <input type="number" class="form-control" id="producto_id" name="producto_id" min="1" value="{{ old('producto_id', $pedido_detalle->producto_id) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar detalle</button>
            </form>
        </div>
    </div>
</div>
@endsection
