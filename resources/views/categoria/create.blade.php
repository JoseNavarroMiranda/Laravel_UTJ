@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Registro de Categoria</h2>
</div>
<div class="row">
       <form action="{{ route('categoria.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
               <label for="nombre">nombre de la categoria</label>
               <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value={{old('nombre_categoria')}} >
           </div>
            <div class="form-group">
               <label for="nombre">descripcion</label>
               <input type="text" class="form-control" id="descripcion" name="descripcion" value={{old('descripcion')}} >
           </div>  
           <button type="submit" class="btn btn-success">Registrar Categoria</button>
       </form>
   </div>
</div>
@endsection
