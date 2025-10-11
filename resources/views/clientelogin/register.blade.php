@extends('vistasbase.body')
@section('title', 'Registro de Cliente')
@section('page_header', 'Crear cuenta')
@section('content')
    <div class="card card-auth">
        <div class="card-body">
            @if ($errors->any())
                <div class="error" style="margin-bottom:12px;">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('cliente.store') }}">
                @csrf

                <div class="grid grid-2">
                    <div>
                        <label class="label" for="nombre">Nombre</label>
                        <input class="input" id="nombre" name="nombre" type="text" placeholder="Tu nombre" value="{{ old('nombre') }}" required>
                    </div>
                    <div>
                        <label class="label" for="email">Correo</label>
                        <input class="input" id="email" name="email" type="email" placeholder="tu@correo.com" value="{{ old('email') }}" required>
                    </div>
                    <div>
                        <label class="label" for="telefono">Teléfono</label>
                        <input class="input" id="telefono" name="telefono" type="tel" placeholder="10 dígitos" value="{{ old('telefono') }}" required>
                    </div>
                    <div>
                        <label class="label" for="ciudad">Ciudad</label>
                        <input class="input" id="ciudad" name="ciudad" type="text" placeholder="Ciudad" value="{{ old('ciudad') }}" required>
                    </div>
                </div>

                <div class="grid" style="margin-top:16px;">
                    <div>
                        <label class="label" for="domicilio">Domicilio</label>
                        <input class="input" id="domicilio" name="domicilio" type="text" placeholder="Calle y número" value="{{ old('domicilio') }}" required>
                    </div>
                    <div>
                        <label class="label" for="cp">Código Postal</label>
                        <input class="input" id="cp" name="cp" type="text" pattern="\d{5}" placeholder="#####" value="{{ old('cp') }}" required>
                        <div class="help">5 dígitos</div>
                    </div>
                </div>

                <div class="grid grid-2" style="margin-top:16px;">
                    <div>
                        <label class="label" for="password">Contraseña</label>
                        <input class="input" id="password" name="password" type="password" required>
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Confirmar contraseña</label>
                        <input class="input" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>

                <div class="spacer"></div>
                <button class="btn block" type="submit">Crear cuenta</button>

                <div class="spacer"></div>
                <div class="muted" style="text-align:center;">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('cliente.login') }}">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
@endsection

