@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h2>Editar proveedor</h2>
            <form action="{{ route('proveedor.update', $proveedor->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="nombre">Nombre del proveedor</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
                </div>
                <div class="form-group">
                    <label for="domicilio">Domicilio fiscal</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{ old('domicilio', $proveedor->domicilio) }}" required>
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad', $proveedor->ciudad) }}" required>
                </div>
                <div class="form-group">
                    <label for="cp">Codigo postal</label>
                    <input type="text" class="form-control" id="cp" name="cp" value="{{ old('cp', $proveedor->cp) }}" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" required>
                </div>
                <div class="form-group">
                    <label for="rfc">RFC</label>
                    <input type="text" class="form-control" id="rfc" name="rfc" value="{{ old('rfc', $proveedor->rfc) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electronico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $proveedor->email) }}" required>
                </div>                <div class="form-group">
                    <label for="estado_proveedor">Estado del proveedor</label>
                    <select class="form-control" id="estado_proveedor" name="estado_proveedor" required>
                        <option value="activo" {{ old('estado_proveedor', $proveedor->estado_proveedor) === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado_proveedor', $proveedor->estado_proveedor) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar proveedor</button>
            </form>
        </div>
    </div>
</div>
@endsection
