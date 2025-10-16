<nav class="vb-navbar">
    <div class="vb-navbar-inner container">
        <div class="vb-brand">
            <a>LineaBlanca</a>
        </div>
        <div class="vb-flex-spacer"></div>
        <div class="vb-auth">
            <a class="vb-cart-link" href="{{ url('/carrito') }}" aria-label="Ver carrito">
                <svg class="vb-cart-icon" viewBox="0 0 24 24" role="img" aria-hidden="true">
                    <path d="M3 3h2l1.55 10.1a2 2 0 0 0 2 1.75h8.22a2 2 0 0 0 2-1.6l1.19-6.6H6.38" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/>
                    <circle cx="10.5" cy="19.5" r="1.4" fill="currentColor"/>
                    <circle cx="17.5" cy="19.5" r="1.4" fill="currentColor"/>
                </svg>
            </a>
            @php($clienteNombreSesion = session('cliente_nombre'))
            @php($clienteActual = Auth::guard('clientes')->user())
            @if($clienteActual)
                @php($nombreVisible = $clienteActual->nombre ?? $clienteActual->email)
                <details class="vb-user-menu">
                    <summary>
                        <span class="vb-user-label">Bienvenido</span>
                        <span class="vb-user-name">{{ $nombreVisible }}</span>
                        <span class="vb-caret" aria-hidden="true">▾</span>
                    </summary>
                    <div class="vb-user-menu-panel">
                        <div class="vb-user-info">
                            <span class="vb-user-info-label">Sesion activa como</span>
                            <span class="vb-user-info-name">{{ $nombreVisible }}</span>
                        </div>
                        <form method="POST" action="{{ route('cliente.logout') }}">
                            @csrf
                            <button type="submit" class="vb-user-menu-logout">Cerrar sesion</button>
                        </form>
                    </div>
                </details>
            @elseif($clienteNombreSesion)
                <span class="muted">Bienvenido,</span>
                <strong>{{ $clienteNombreSesion }}</strong>
            @else
                <a class="vb-login-link" href="{{ route('cliente.login') }}">Iniciar sesion</a>
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
        .vb-login-link{ color: #fff; font-weight:600; text-decoration:none; padding:8px 14px; border-radius:8px; border:1px solid rgba(255,255,255,0.2); transition: background .15s ease, color .15s ease; }
        .vb-login-link:hover{ background: rgba(255,255,255,0.1); color:#fff; }
        .vb-cart-link{
            display:inline-flex; align-items:center; justify-content:center;
            width:40px; height:40px;
            border-radius:12px;
            border:1px solid rgba(255,255,255,0.18);
            color:#fff;
            transition: background .15s ease, border-color .15s ease, transform .15s ease;
        }
        .vb-cart-link:hover{
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }
        .vb-cart-icon{ width:22px; height:22px; }
        .vb-user-menu{ position:relative; display:inline-block; color:#ccc; }
        .vb-user-menu > summary{ list-style:none; display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px; cursor:pointer; transition: background .15s ease; }
        .vb-user-menu > summary::-webkit-details-marker{ display:none; }
        .vb-user-menu > summary:hover,
        .vb-user-menu[open] > summary{ background: rgba(255,255,255,0.08); }
        .vb-user-label{ font-size:14px; color:#9ca3af; }
        .vb-user-name{ color:#fff; font-weight:600; }
        .vb-caret{ font-size:12px; color:#9ca3af; }
        .vb-user-menu-panel{ position:absolute; right:0; margin-top:12px; background:#111827; border:1px solid rgba(255,255,255,0.12); border-radius:12px; padding:16px; min-width:220px; box-shadow:0 18px 35px rgba(0,0,0,0.45); display:flex; flex-direction:column; gap:14px; }
        .vb-user-info{ display:flex; flex-direction:column; gap:4px; }
        .vb-user-info-label{ font-size:12px; text-transform:uppercase; letter-spacing:0.4px; color:#9ca3af; }
        .vb-user-info-name{ font-weight:600; color:#fff; }
        .vb-user-menu-logout{ width:100%; padding:10px 14px; border-radius:8px; border:0; background:#ef4444; color:#0b1220; font-weight:600; cursor:pointer; transition: filter .15s ease, transform .05s ease; }
        .vb-user-menu-logout:hover{ filter:brightness(1.08); }
        .vb-user-menu-logout:active{ transform:translateY(1px); }
    </style>
</nav>

