@extends('vistasbase.body')
@section('title', 'Restablecer contraseña')
@section('page_header', 'Crear nueva contraseña')
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

            <form method="POST" action="{{ route('cliente.password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="grid">
                    <div>
                        <label class="label" for="email">Correo</label>
                        <input class="input" id="email" name="email" type="email" value="{{ old('email', $email) }}" placeholder="tu@correo.com" required>
                    </div>
                    <div>
                        <label class="label" for="password">Nueva contraseña</label>
                        <input class="input" id="password" name="password" type="password" required>
                        <div class="help">Mínimo 8 caracteres</div>
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Confirmar contraseña</label>
                        <input class="input" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>

                <div class="spacer"></div>
                <button class="btn block" type="submit">Guardar contraseña</button>

                <div class="spacer"></div>
                <div class="muted" style="text-align:center;">
                    ¿Ya puedes iniciar sesión?
                    <a href="{{ route('cliente.login') }}">Volver al acceso</a>
                </div>
            </form>
        </div>
    </div>
@endsection
