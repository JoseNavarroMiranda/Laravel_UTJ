<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Notificación del sistema</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            color: #333;
            margin: 0;
            padding: 0;
        }


        /* Contenedor principal */
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }


        /* Encabezado */
        .header {
            background-color: #2563eb;
            /* azul Laravel */
            color: #ffffff;
            padding: 20px 30px;
            text-align: center;
        }


        .header h1 {
            font-size: 22px;
            margin: 0;
            letter-spacing: 0.5px;
        }


        /* Cuerpo */
        .content {
            padding: 30px;
            line-height: 1.6;
        }


        .content p {
            font-size: 16px;
            margin-bottom: 20px;
        }


        /* Botón de acción (opcional) */
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 10px;
        }


        /* Pie de página */
        .footer {
            background-color: #f1f5f9;
            color: #64748b;
            font-size: 13px;
            text-align: center;
            padding: 15px 20px;
            border-top: 1px solid #e2e8f0;
        }


        .footer small {
            display: block;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <div class="container">


        <!-- ENCABEZADO -->
        <div class="header">
            <h1>Notificación desde Laravel</h1>
        </div>


        <!-- CONTENIDO -->
        <div class="content">
            <p>{{ $mensaje }}</p>


            {{-- Ejemplo de botón opcional, por si luego quieres agregar un enlace --}}
            {{-- <a href="https://tusitio.com" class="button">Ver más detalles</a> --}}
        </div>


        <!-- PIE DE PÁGINA -->
        <div class="footer">
            <small>Este correo fue enviado automáticamente por el sistema Laravel 12.<br>
                No respondas a este mensaje.</small>
        </div>
    </div>
</body>

</html>
