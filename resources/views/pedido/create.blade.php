@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Registro de Pedido</h2>
</div>
<div class="row">
    <p class="text-end">
        <a href="{{ route('pedido.index') }}" class="btn btn-primary">Regresar</a>
    </p>
       <form action="{{ route('pedido.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
           @csrf <!-- Protección contra ataques ya implementado en laravel  https://www.welivesecurity.com/la-es/2015/04/21/vulnerabilidad-cross-site-request-forgery-csrf/-->
           @if (session('success'))
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
               <label for="fecha_pedido">Fecha del pedido</label>
               <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" value="{{ old('fecha_pedido') }}">
           </div>
           <div class="form-group">
               <label for="estado_pedido">Estado del pedido</label>
               <input type="text" class="form-control" id="estado_pedido" name="estado_pedido" placeholder="Ej. pendiente" value="{{ old('estado_pedido') }}">
           </div>
           <div class="form-group">
               <label for="metodo_pago">Método de pago</label>
               <input type="text" class="form-control" id="metodo_pago" name="metodo_pago" placeholder="Ej. tarjeta, efectivo" value="{{ old('metodo_pago') }}">
           </div>
           <div class="form-group">
               <label for="total">Total</label>
               <input type="number" class="form-control" id="total" name="total" step="0.01" min="0" value="{{ old('total') }}">
           </div>
           <div class="form-group">
               <label for="cliente_id">Cliente</label>
               @if(isset($clientes) && $clientes->isNotEmpty())
                   <select class="form-control" id="cliente_id" name="cliente_id" required>
                       <option value="">Selecciona un cliente</option>
                       @foreach($clientes as $cliente)
                           <option value="{{ $cliente->id }}" {{ (string) old('cliente_id') === (string) $cliente->id ? 'selected' : '' }}>
                               {{ $cliente->nombre }} ({{ $cliente->email }})
                           </option>
                       @endforeach
                   </select>
               @else
                   <input type="number" class="form-control" id="cliente_id" name="cliente_id" placeholder="Ingresa el ID del cliente" value="{{ old('cliente_id') }}">
               @endif
           </div>
           <button type="submit" class="btn btn-success">Registrar Pedido</button>
       </form>
   </div>
</div>
@endsection
