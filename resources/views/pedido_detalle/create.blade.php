@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Registrar detalle de pedido</h2>
</div>
<div class="row">
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
               <input type="number" class="form-control" id="pedido_id" name="pedido_id" min="1" placeholder="ID del pedido" value="{{ old('pedido_id') }}">
           </div>
           <div class="form-group">
               <label for="producto_id">Producto</label>
               <input type="number" class="form-control" id="producto_id" name="producto_id" min="1" placeholder="ID del producto" value="{{ old('producto_id') }}">
           </div>
           <button type="submit" class="btn btn-success">Guardar detalle</button>
       </form>
   </div>
</div>
@endsection
