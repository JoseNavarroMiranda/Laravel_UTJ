<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de clientes activos</title>
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
            min-width: 160px;
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
        <h1>Informe de clientes activos</h1>
        <p>Fecha de elaboración: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </header>

    <section class="resumen">
        <div><strong>Total de clientes activos:</strong> {{ $clientes->count() }}</div>
        <div><strong>Periodo analizado:</strong> Desde el registro inicial hasta la fecha actual</div>
        <div><strong>Criterio aplicado:</strong> Clientes con estatus operativo vigente</div>
    </section>

    @forelse($clientes as $cliente)
        <article>
            <h2>{{ $loop->iteration }}. {{ $cliente->nombre }}</h2>

            <div class="campo">
                <strong>Ubicación:</strong>
                {{ $cliente->domicilio ?? 'Domicilio no registrado' }},
                {{ $cliente->ciudad ?? 'Ciudad no registrada' }},
                CP {{ $cliente->cp ?? '-----' }}
            </div>

            <div class="campo">
                <strong>Contacto:</strong>
                Tel. {{ $cliente->telefono ?? 'Sin teléfono' }} |
                Correo {{ $cliente->email ?? 'Sin correo' }}
            </div>

            <div class="campo">
                <strong>Fecha de alta:</strong>
                {{ optional($cliente->created_at)->format('d/m/Y') ?? 'Sin registro' }}
            </div>

            @php
                $camposRelacionados = [
                    'municipio' => 'Municipio',
                    'estado' => 'Estado',
                    'categoria' => 'Categoría',
                    'segmento' => 'Segmento'
                ];
            @endphp

            @foreach($camposRelacionados as $relacion => $etiqueta)
                @if(method_exists($cliente, $relacion) && $cliente->relationLoaded($relacion))
                    <div class="campo">
                        <strong>{{ $etiqueta }}:</strong>
                        {{ optional($cliente->$relacion)->nombre ?? 'Sin información' }}
                    </div>
                @endif
            @endforeach
        </article>
    @empty
        <p class="texto-vacio">No se encontraron clientes activos para el periodo analizado.</p>
    @endforelse
</body>
</html>
