<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #111827;
            margin: 0;
            padding: 36px 40px;
        }
        h1 {
            font-size: 28px;
            margin: 0 0 8px;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }
        .invoice-meta {
            text-align: right;
            color: #374151;
            line-height: 1.6;
        }
        .invoice-section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: 600;
        }
        .blank {
            display: inline-block;
            min-width: 220px;
            border-bottom: 1px solid #111827;
            margin-left: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        .summary {
            margin-top: 14px;
            display: flex;
            justify-content: flex-end;
            font-size: 16px;
        }
        .summary span {
            font-weight: 600;
            margin-left: 10px;
        }
        .notes {
            margin-top: 28px;
            color: #374151;
        }
        .signatures {
            margin-top: 42px;
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }
        .signature-slot {
            flex: 1;
            text-align: center;
            padding-top: 6px;
            border-top: 1px solid #111827;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div>
            <h1>Factura</h1>
            <div class="invoice-meta">
                Fecha: {{ $fechaFactura }}<br>
                Folio: ________________________
            </div>
        </div>
        <div class="invoice-meta">
            Atención a:<br>
            <span class="label">Nombre:</span> {{ $cliente->nombre ?? '___________________________' }}<br>
            <span class="label">Correo:</span> {{ $cliente->email ?? '___________________________' }}<br>
            <span class="label">Teléfono:</span> {{ $cliente->telefono ?? '___________________________' }}
        </div>
    </div>

    <div class="invoice-section">
        <span class="label">Dirección:</span> ________________________________<br>
        <span class="label">RFC:</span> ________________________________<br>
        <span class="label">Método de pago:</span> ________________________________
    </div>

    <div class="invoice-section">
        <table>
            <thead>
                <tr>
                    <th style="width: 45%;">Producto</th>
                    <th style="width: 15%;">Cantidad</th>
                    <th style="width: 20%;">Precio Unitario</th>
                    <th style="width: 20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    @php
                        $cantidad = (int)($item['cantidad'] ?? 0);
                        $precio = (float)($item['precio'] ?? 0);
                        $subtotal = (float)($item['subtotal'] ?? $cantidad * $precio);
                    @endphp
                    <tr>
                        <td>{{ $item['nombre'] ?? 'Producto' }}</td>
                        <td>{{ $cantidad }}</td>
                        <td>${{ number_format($precio, 2) }}</td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Sin productos en el carrito.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="summary">
        Total a pagar: <span>${{ number_format($total, 2) }}</span>
    </div>

    <div class="notes">
        <p><span class="label">Notas:</span> _____________________________________________________________</p>
        <p>Entregado por: _____________________________ &nbsp;&nbsp;&nbsp; Recibido por: _____________________________</p>
    </div>

    <div class="signatures">
        <div class="signature-slot">Firma del vendedor</div>
        <div class="signature-slot">Firma del cliente</div>
    </div>
</body>
</html>
