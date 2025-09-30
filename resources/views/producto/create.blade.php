@extends('adminlte::page')
@section('content')
<div class="container">
   <div class="row">
       <h2>Registro de Producto</h2>
</div>
<div class="row">
       <form action="{{ route('producto.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
               <label for="nombre">nombre</label>
               <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value={{old('nombre_producto')}} >
           </div>
            <div class="form-group">
               <label for="nombre">descripcion</label>
               <input type="text" class="form-control" id="descripcion" name="descripcion" value={{old('descripcion')}} >
           </div>
           <div class="form-group">
               <label for="nombre">precio</label>
               <input type="text" class="form-control" id="precio" name="precio" value={{old('precio')}} >
           </div>
           <div class="form-group">
               <label for="nombre">stock</label>
               <input type="text" class="form-control" id="stock" name="stock"  value={{old('stock')}}>
           </div>
           <div class="form-group">
               <label for="nombre">categoria</label>
               <input type="text" class="form-control" id="categoria_id" name="categoria_id" placeholder="Selecciona el tipo de categoria" value={{old('categoria_id')}} >
           </div>
            <div class="form-group">
               <label for="nombre">proveedor</label>
               <input type="text" class="form-control" id="proveedor_id" name="proveedor_id" placeholder="Selecciona el proveedor" value={{old('proveedor_id')}}>
            </div> 
            <div class="form-group">
               <label for="imagen_producto">Imagen del producto</label>
               <input type="file" class="form-control" id="imagen_producto" name="imagen_producto">
            </div>
            <div class="form-group">
               <label for="video_producto">Video del producto</label>
               <input type="file" class="form-control" id="video_producto" name="video_producto">
            </div>
           <button type="submit" class="btn btn-success">Registrar Producto</button>
       </form>
   </div>
</div>
@endsection
