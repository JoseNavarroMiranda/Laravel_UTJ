@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Registrar detalle de pedido</h2>
</div>
<div class="row">
    <p class="text-end">
        <a href="{{ route('pedido_detalle.index') }}" class="btn btn-primary">Regresar</a>
    </p>
       <form action="{{ route('pedido_detalle.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
           @csrf <!-- Protección contra ataques ya implementado en laravel  https://www.welivesecurity.com/la-es/2015/04/21/vulnerabilidad-cross-site-request-forgery-csrf/-->
           @if(session('success'))
               <div class="alert alert-success">
                   {{ session('success') }}
               </div>
           @endif
           @if($errors->any())
               <div class="alert alert-danger">
                   <ul>
                       @foreach($errors->all() as $error)
                           <li>{{$error}}</li>
                       @endforeach
                   </ul>
               </div>
           @endif
           <div class="form-group">
               <label for="cantidad">Cantidad</label>
               <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad') }}">
           </div>
           <div class="form-group">
               <label for="precio_unitario">Precio unitario</label>
               <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" step="0.01" min="0" value="{{ old('precio_unitario') }}">
           </div>
           <div class="form-group">
               <label for="subtotal">Subtotal</label>
               <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" min="0" value="{{ old('subtotal') }}">
           </div>
           <div class="form-group">
               <label for="pedido_id">Pedido</label>
               @if(isset($pedidos) && $pedidos->isNotEmpty())
                   <select class="form-control" id="pedido_id" name="pedido_id" required>
                       <option value="">Selecciona un pedido</option>
                       @foreach($pedidos as $pedido)
                           <option value="{{ $pedido->id }}" {{ (string) old('pedido_id') === (string) $pedido->id ? 'selected' : '' }}>
                               Pedido #{{ $pedido->id }} - {{ optional($pedido->fecha_pedido)->format('Y-m-d') }}
                           </option>
                       @endforeach
                   </select>
               @else
                   <input type="number" class="form-control" id="pedido_id" name="pedido_id" min="1" placeholder="ID del pedido" value="{{ old('pedido_id') }}">
               @endif
           </div>
           <div class="form-group">
               <label for="producto_id">Producto</label>
               @if(isset($productos) && $productos->isNotEmpty())
                   <select class="form-control" id="producto_id" name="producto_id" required>
                       <option value="">Selecciona un producto</option>
                       @foreach($productos as $producto)
                           <option value="{{ $producto->id }}" {{ (string) old('producto_id') === (string) $producto->id ? 'selected' : '' }}>
                               {{ $producto->nombre_producto }}
                           </option>
                       @endforeach
                   </select>
               @else
                   <input type="number" class="form-control" id="producto_id" name="producto_id" min="1" placeholder="ID del producto" value="{{ old('producto_id') }}">
               @endif
           </div>
           <button type="submit" class="btn btn-success">Guardar detalle</button>
       </form>
   </div>
</div>
@endsection
