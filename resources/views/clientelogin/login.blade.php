@extends('vistasbase.body')

@section('title', 'Iniciar sesión')
@section('page_header', 'Iniciar sesión')

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

            <form method="POST" action="#">
                @csrf

                <div class="grid">
                    <div>
                        <label class="label" for="email">Correo</label>
                        <input class="input" id="email" name="email" type="email" placeholder="tu@correo.com" required>
                    </div>
                    <div>
                        <label class="label" for="password">Contraseña</label>
                        <input class="input" id="password" name="password" type="password" required>
                    </div>
                </div>

                <div class="spacer"></div>
                <button class="btn block" type="submit">Entrar</button>

                <div class="spacer"></div>
                <div class="muted" style="text-align:center;">
                    ¿No tienes cuenta?
                    {{-- Usa la ruta que prefieras: cliente.register o cliente.create --}}
                    <a href="{{ route('cliente.register', [], false) ?: route('cliente.create') }}">Crear cuenta</a>
                </div>
            </form>
        </div>
    </div>
@endsection
