<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3449 100%);
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background: #FCC200;
            color: #2c4a6b;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Has sido invitado!</h1>
        </div>

        <div class="content">
            <p>Hola {{ $user->first_name }},</p>

            <p>
                Has sido invitado a utilizar nuestra aplicación móvil para la gestión de obras.
            </p>

            <p><strong>¿Qué debes hacer?</strong></p>

            <ul>
                <li>Descarga la aplicación desde tu tienda</li>
                <li>Ingresa con tu correo: <strong>{{ $user->email }}</strong></li>
                <li>Crea tu contraseña dentro de la app</li>
            </ul>

            <div style="text-align: center;">
                <a href="#" class="button">Descargar en Android</a>
                <a href="#" class="button">Descargar en iOS</a>
            </div>

            <p>
                Si tienes algún problema para acceder, contacta al administrador.
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Sistema de Gestión de Obras</p>
        </div>
    </div>
</body>
</html>