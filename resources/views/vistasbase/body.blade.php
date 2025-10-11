<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplicación')</title>

    <style>
        :root{
            --bg: #0f172a;           /* slate-900 */
            --bg-soft: #111827;      /* gray-900 */
            --panel: #111827;        /* gray-900 */
            --panel-border: #1f2937; /* gray-800 */
            --text: #e5e7eb;         /* gray-200 */
            --muted: #9ca3af;        /* gray-400 */
            --primary: #22c55e;      /* green-500 */
            --primary-600: #16a34a;  /* green-600 */
            --danger: #ef4444;       /* red-500 */
            --focus: #93c5fd;        /* blue-300 */
            --ring: rgba(147,197,253,0.35);
        }
        *, *::before, *::after{ box-sizing: border-box; }
        html, body{ height: 100%; }
        body{
            margin: 0;
            color: var(--text);
            background:
              radial-gradient(1200px 500px at 10% -10%, rgba(34,197,94,0.12), transparent 60%),
              radial-gradient(900px 400px at 110% 10%, rgba(59,130,246,0.12), transparent 60%),
              linear-gradient(180deg, #0b1220 0%, #0f172a 40%, #0b1220 100%);
            font: 400 16px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        a{ color: var(--primary); text-decoration: none; }
        a:hover{ color: var(--primary-600); }

        .container{
            max-width: 1000px;
            margin: 0 auto;
            padding: 24px;
        }
        .page-header{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 16px 0 24px;
        }
        .page-header h1{
            margin: 0;
            font-size: 26px;
            letter-spacing: .2px;
        }
        .content{ }

        .card{
            background: linear-gradient(180deg, rgba(17,24,39,0.85), rgba(17,24,39,0.95));
            border: 1px solid var(--panel-border);
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.03);
        }
        .card-body{ padding: 24px; }
        .card-auth{ max-width: 520px; margin: 32px auto; }

        .grid{ display: grid; gap: 16px; }
        .grid-2{ grid-template-columns: 1fr 1fr; }
        @media (max-width: 640px){ .grid-2{ grid-template-columns: 1fr; } }

        .label{ display:block; margin: 6px 0 6px; color: var(--muted); font-size: 14px; }
        .input{
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--panel-border);
            background: #0b1220;
            color: var(--text);
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .input:focus{
            border-color: var(--focus);
            box-shadow: 0 0 0 4px var(--ring);
        }
        .help{ color: var(--muted); font-size: 13px; margin-top: 6px; }
        .error{ color: var(--danger); font-size: 13px; margin-top: 6px; }

        .btn{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            border: 0;
            border-radius: 10px;
            background: var(--primary);
            color: #0a0f1a;
            font-weight: 600;
            cursor: pointer;
            transition: transform .05s ease, filter .15s ease, background .15s ease;
        }
        .btn:hover{ filter: brightness(1.08); }
        .btn:active{ transform: translateY(1px); }
        .btn.secondary{ background: #1f2937; color: var(--text); }
        .btn.block{ width: 100%; }

        .muted{ color: var(--muted); }
        .spacer{ height: 12px; }
    </style>

    @stack('styles')
</head>
<body>
    @includeIf('vistasbase.header')

    <main class="container">
        @hasSection('page_header')
            <div class="page-header">
                <h1>@yield('page_header')</h1>
                @yield('page_actions')
            </div>
        @endif

        <div class="content">
            @yield('content')
        </div>
    </main>

    @includeIf('vistasbase.footer')

    @stack('scripts')
</body>
</html>
