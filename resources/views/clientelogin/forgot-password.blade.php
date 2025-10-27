@extends('vistasbase.body')
@section('title', 'Recuperar contraseña')
@section('page_header', '¿Olvidaste tu contraseña?')
@section('content')
    <div class="card card-auth">
        <div class="card-body">
            @if (session('status'))
                <div class="success" style="margin-bottom:12px;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error" style="margin-bottom:12px;">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('cliente.password.email') }}">
                @csrf

                <div>
                    <label class="label" for="email">Correo</label>
                    <input class="input" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="tu@correo.com" required autofocus>
                </div>

                <div class="spacer"></div>
                <button class="btn block" type="submit">Enviar enlace de restablecimiento</button>

                <div class="spacer"></div>
                <div class="muted" style="text-align:center;">
                    ¿Recordaste tu contraseña?
                    <a href="{{ route('cliente.login') }}">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
@endsection
