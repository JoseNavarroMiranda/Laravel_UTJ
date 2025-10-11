<nav class="vb-navbar">
    <div class="vb-navbar-inner container">
        <div class="vb-brand">
            <a href="{{ url('/') }}">LineaBlanca</a>
        </div>
        <div class="vb-flex-spacer"></div>
        <div class="vb-auth">
            @php($clienteNombreSesion = session('cliente_nombre'))
            @php($clienteActual = Auth::guard('clientes')->user())
            @if($clienteActual)
                <span class="muted">Bienvenido,</span>
                <strong>{{ $clienteActual->nombre ?? $clienteActual->email }}</strong>
            @elseif($clienteNombreSesion)
                <span class="muted">Bienvenido,</span>
                <strong>{{ $clienteNombreSesion }}</strong>
            @else
                <span class="muted">No has iniciado sesion</span>
            @endif
        </div>
    </div>

    <style>
        .vb-navbar {
            position: sticky; top: 0; z-index: 50;
            background: linear-gradient(180deg, rgba(11,18,32,.95), rgba(11,18,32,.75));
            border-bottom: 1px solid #1f2937;
            backdrop-filter: blur(6px);
        }
        .vb-navbar-inner {
            display: flex; align-items: center; gap: 16px;
            padding: 12px 24px;
        }
        .vb-brand a { font-weight: 700; letter-spacing: .3px; color: white; text-decoration: none; }
        .vb-flex-spacer { flex: 1; }
        .vb-auth { display:flex; align-items:center; gap:8px; color: #ccc; }
        .vb-auth strong { color: #fff; }
    </style>
</nav>


