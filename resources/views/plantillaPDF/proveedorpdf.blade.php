<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de proveedores activos</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: "Helvetica", Arial, sans-serif;
            margin: 32px;
            color: #1a1a1a;
            font-size: 13px;
            line-height: 1.5;
        }
        header {
            text-align: center;
            margin-bottom: 28px;
        }
        header h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.5px;
        }
        header p {
            margin: 4px 0 0;
            color: #555;
            font-size: 12px;
        }
        .resumen {
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            padding: 16px;
            margin-bottom: 24px;
        }
        .resumen strong {
            display: inline-block;
            min-width: 140px;
        }
        article {
            border-bottom: 1px solid #d9d9d9;
            padding: 16px 0;
        }
        article:last-of-type {
            border-bottom: none;
        }
        article h2 {
            margin: 0 0 8px;
            font-size: 16px;
            color: #0d47a1;
        }
        .campo {
            margin: 4px 0;
        }
        .campo strong {
            display: inline-block;
            min-width: 120px;
            color: #333;
        }
        .texto-vacio {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 32px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Informe de proveedores activos</h1>
        <p>Fecha de elaboracion: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </header>

    <section class="resumen">
        <div><strong>Total de proveedores activos:</strong> {{ $proveedores->count() }}</div>
        <div><strong>Periodo analizado:</strong> Desde el alta registrada hasta la fecha actual</div>
        <div><strong>Estado considerado:</strong> Proveedores con estatus "activo"</div>
    </section>

    @forelse($proveedores as $proveedor)
        <article>
            <h2>{{ $loop->iteration }}. {{ $proveedor->nombre }}</h2>

            <div class="campo">
                <strong>Ubicacion:</strong>
                {{ $proveedor->domicilio }}, {{ $proveedor->ciudad }}, CP {{ $proveedor->cp }}
            </div>

            <div class="campo">
                <strong>Contacto:</strong>
                Tel. {{ $proveedor->telefono }} | Correo {{ $proveedor->email }}
            </div>

            <div class="campo">
                <strong>RFC:</strong>
                {{ $proveedor->rfc }}
            </div>

            <div class="campo">
                <strong>Estatus actual:</strong>
                {{ ucfirst($proveedor->estado_proveedor) }}
            </div>

            <div class="campo">
                <strong>Fecha de alta:</strong>
                {{ optional($proveedor->created_at)->format('d/m/Y') ?? 'Sin registro' }}
            </div>

            @if(method_exists($proveedor, 'categoria') && $proveedor->relationLoaded('categoria'))
                <div class="campo">
                    <strong>Categoria:</strong>
                    {{ $proveedor->categoria->nombre ?? 'Sin categoria asociada' }}
                </div>
            @endif
        </article>
    @empty
        <p class="texto-vacio">No se encontraron proveedores activos para el periodo analizado.</p>
    @endforelse
</body>
</html>
