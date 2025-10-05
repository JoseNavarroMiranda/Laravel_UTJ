@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <h2>Editar categoria</h2>
    </div>
    <div class="row">
        <form action="{{ route('categoria.update', $categoria->id) }}" method="POST" class="col-lg-7">
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
                <label for="nombre_categoria">Nombre de la categoria</label>
                <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="{{ old('nombre_categoria', $categoria->nombre_categoria) }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $categoria->descripcion) }}">
            </div>
            <div class="form-group">
                <label for="estado_categoria">Estado</label>
                <select class="form-control" id="estado_categoria" name="estado_categoria" required>
                    <option value="activo" {{ old('estado_categoria', $categoria->estado_categoria) === 'activo' ? 'selected' : '' }}>Activa</option>
                    <option value="inactivo" {{ old('estado_categoria', $categoria->estado_categoria) === 'inactivo' ? 'selected' : '' }}>Inactiva</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar categoria</button>
        </form>
    </div>
</div>
@endsection
