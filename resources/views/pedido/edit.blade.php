@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <h2>Editar pedido</h2>
            <form action="{{ route('pedido.update', $pedido->id) }}" method="POST" class="mt-3">
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
                    <label for="fecha_pedido">Fecha del pedido</label>
                    <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" value="{{ old('fecha_pedido', $pedido->fecha_pedido) }}" required>
                </div>
                <div class="form-group">
                    <label for="estado_pedido">Estado del pedido</label>
                    <select class="form-control" id="estado_pedido" name="estado_pedido" required>
                        <option value="pendiente" {{ old('estado_pedido', $pedido->estado_pedido) === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en preparacion" {{ old('estado_pedido', $pedido->estado_pedido) === 'en preparacion' ? 'selected' : '' }}>En preparacion</option>
                        <option value="autorizado" {{ old('estado_pedido', $pedido->estado_pedido) === 'autorizado' ? 'selected' : '' }}>Autorizado</option>
                        <option value="entregado" {{ old('estado_pedido', $pedido->estado_pedido) === 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="enviado" {{ old('estado_pedido', $pedido->estado_pedido) === 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="devuelto" {{ old('estado_pedido', $pedido->estado_pedido) === 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="metodo_pago">Metodo de pago</label>
                    <input type="text" class="form-control" id="metodo_pago" name="metodo_pago" value="{{ old('metodo_pago', $pedido->metodo_pago) }}" required>
                </div>
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="number" class="form-control" id="total" name="total" step="0.01" min="0" value="{{ old('total', $pedido->total) }}" required>
                </div>
                <div class="form-group">
                    <label for="cliente_id">ID del cliente</label>
                    <input type="number" class="form-control" id="cliente_id" name="cliente_id" min="1" value="{{ old('cliente_id', $pedido->cliente_id) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar pedido</button>
            </form>
        </div>
    </div>
</div>
@endsection
