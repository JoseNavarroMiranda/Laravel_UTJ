@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Registro de Producto</h2>
</div>
<div class="row">
       <form action="{{ route('pedido.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
           @csrf <!-- Protección contra ataques ya implementado en laravel  https://www.welivesecurity.com/la-es/2015/04/21/vulnerabilidad-cross-site-request-forgery-csrf/-->
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
               <label for="nombre">nombre</label>
               <input type="text" class="form-control" id="nombre" name="nombre" value={{old('nombre')}} >
           </div>
            <div class="form-group">
               <label for="nombre">domicilio</label>
               <input type="text" class="form-control" id="domicilio" name="domicilio" value={{old('domicilio')}} >
           </div>
           <div class="form-group">
               <label for="nombre">ciudad</label>
               <input type="text" class="form-control" id="ciudad" name="ciudad" value={{old('ciudad')}} >
           </div>
           <div class="form-group">
               <label for="nombre">C.P</label>
               <input type="text" class="form-control" id="cp" name="cp" placeholder="Ej. 45654" value={{old('cp')}}>
           </div>
            <div class="form-group">
               <label for="nombre">telefono</label>
               <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresa un numero telefonico NO mayor a 10 digitos" value={{old('telefono')}} >
            <div class="form-group">
               <label for="nombre">email</label>
               <input type="text" class="form-control" id="email" name="email" value={{old('email')}}>
            </div>
            <div class="form-group">
               <label for="nombre">password</label>
               <input type="text" class="form-control" id="password" name="password" placeholder="Ingresa una contraseña segura" value={{old('password')}}>
           </div>      
           <button type="submit" class="btn btn-success">Registrar Cliente</button>
       </form>
   </div>
</div>
@endsection
