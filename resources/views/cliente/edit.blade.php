@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h2>Editar cliente</h2>
            <form action="{{ route('cliente.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                </div>
                <div class="form-group">
                    <label for="domicilio">Domicilio</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{ old('domicilio', $cliente->domicilio) }}" required>
                </div>
                <div class="form-group">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad', $cliente->ciudad) }}" required>
                </div>
                <div class="form-group">
                    <label for="cp">Código postal</label>
                    <input type="text" class="form-control" id="cp" name="cp" value="{{ old('cp', $cliente->cp) }}" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="password">nueva contraseña Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="********">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar cliente</button>
            </form>
        </div>
    </div>
</div>
@endsection
