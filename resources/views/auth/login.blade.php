<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Constructora 33</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #2c4a6b 0%, #1a3049 100%);
            position: relative;
            overflow: hidden;
        }

        /* Patrón de edificios en el fondo */
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100"><rect x="5" y="60" width="15" height="40" fill="rgba(255,255,255,0.03)"/><rect x="10" y="65" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="13" y="65" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="10" y="70" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="13" y="70" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="25" y="50" width="18" height="50" fill="rgba(255,255,255,0.03)"/><rect x="30" y="55" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="35" y="55" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="30" y="60" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="35" y="60" width="2" height="3" fill="rgba(255,255,255,0.05)"/><rect x="50" y="40" width="20" height="60" fill="rgba(255,255,255,0.03)"/><rect x="55" y="45" width="3" height="4" fill="rgba(255,255,255,0.05)"/><rect x="62" y="45" width="3" height="4" fill="rgba(255,255,255,0.05)"/><rect x="55" y="52" width="3" height="4" fill="rgba(255,255,255,0.05)"/><rect x="62" y="52" width="3" height="4" fill="rgba(255,255,255,0.05)"/><rect x="75" y="55" width="16" height="45" fill="rgba(255,255,255,0.03)"/><rect x="100" y="65" width="14" height="35" fill="rgba(255,255,255,0.03)"/><rect x="120" y="45" width="22" height="55" fill="rgba(255,255,255,0.03)"/><rect x="125" y="50" width="3" height="4" fill="rgba(255,255,255,0.05)"/><rect x="133" y="50" width="3" height="4" fill="rgba(255,255,255,0.05)"/><rect x="147" y="58" width="17" height="42" fill="rgba(255,255,255,0.03)"/><rect x="170" y="70" width="13" height="30" fill="rgba(255,255,255,0.03)"/></svg>');
            background-size: 800px;
            background-repeat: repeat-x;
            background-position: bottom;
            pointer-events: none;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1400px;
            margin: auto;
            position: relative;
            z-index: 1;
            gap: 40px;
            padding: 40px;
        }

        .left-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .left-content {
            max-width: 600px;
        }

        .logo-container {
            background: rgba(90, 100, 90, 0.6);
            backdrop-filter: blur(10px);
            padding: 30px 40px;
            border-radius: 20px;
            margin-bottom: 50px;
            border: 2px solid rgba(252, 194, 0, 0.3);
            display: inline-block;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .logo-image {
            height: 80px;
            width: auto;
        }

        .welcome-text h1 {
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            color: #ffffff;
        }

        .welcome-text p {
            font-size: 18px;
            opacity: 0.85;
            line-height: 1.6;
            color: #c5d0e0;
            margin-bottom: 50px;
        }

        .features {
            display: flex;
            gap: 20px;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            padding: 20px 28px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: rgba(252, 194, 0, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .feature-text {
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
        }

        .right-panel {
            flex: 0 0 480px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            padding: 50px 45px;
            border-radius: 28px;
            box-shadow: 
                0 25px 70px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            width: 100%;
            backdrop-filter: blur(20px);
        }

        .login-header {
            margin-bottom: 36px;
        }

        .login-header h2 {
            font-size: 30px;
            color: #2c4a6b;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .login-header p {
            color: #6b7280;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2c4a6b;
            font-weight: 600;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            z-index: 1;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
            color: #2c4a6b;
        }

        .form-control:focus {
            outline: none;
            border-color: #FCC200;
            background: white;
            box-shadow: 0 0 0 3px rgba(252, 194, 0, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 17px;
            height: 17px;
            cursor: pointer;
            accent-color: #FCC200;
        }

        .remember-me label {
            color: #4b5563;
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            color: #FCC200;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #e5ae00;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #FCC200 0%, #f5b800 100%);
            color: #2c4a6b;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(252, 194, 0, 0.35);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(252, 194, 0, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            color: #6b7280;
            font-size: 14px;
        }

        .footer-text a {
            color: #FCC200;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            color: #e5ae00;
        }

        @media (max-width: 1100px) {
            .container {
                padding: 30px 20px;
            }

            .left-panel {
                padding: 20px;
            }

            .welcome-text h1 {
                font-size: 42px;
            }

            .features {
                flex-direction: column;
            }
        }

        @media (max-width: 900px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                flex: 1;
            }

            .container {
                justify-content: center;
            }
        }

        @media (max-width: 640px) {
            .login-card {
                padding: 40px 30px;
            }

            .login-header h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="left-content">
                <div class="logo-container">
                    {{-- <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 150'%3E%3Cdefs%3E%3Cstyle%3E.cls-1%7Bfill:%23fcc200;%7D%3C/style%3E%3C/defs%3E%3Cpath class='cls-1' d='M50,40 L50,40 Q55,35 65,35 L80,35 Q85,35 88,38 L130,80 Q135,85 135,92 L135,110 Q135,115 130,115 L50,115 Q45,115 45,110 L45,45 Q45,40 50,40 Z'/%3E%3Cpath class='cls-1' d='M155,40 L155,40 Q160,35 170,35 L185,35 Q190,35 193,38 L235,80 Q240,85 240,92 L240,110 Q240,115 235,115 L155,115 Q150,115 150,110 L150,45 Q150,40 155,40 Z'/%3E%3Cpath class='cls-1' d='M260,35 L350,35 Q355,35 355,40 L355,52 Q355,57 350,57 L280,57 L280,67 L340,67 Q345,67 345,72 L345,83 Q345,88 340,88 L280,88 L280,98 L350,98 Q355,98 355,103 L355,110 Q355,115 350,115 L260,115 Q255,115 255,110 L255,40 Q255,35 260,35 Z'/%3E%3Ctext x='140' y='140' font-family='Arial' font-size='40' fill='%23fcc200' font-weight='bold'%3E33%3C/text%3E%3C/svg%3E" alt="Logo" class="logo-image"> --}}
                     <img src="{{ asset('images/logo33.png') }}" alt="CUBIC33" style="width: 300px; height: auto; margin: 0 auto;">

                </div>
                
                <div class="welcome-text">
                    <h1>Bienvenido al Portal de Construcción</h1>
                    <p>Gestiona tus proyectos, equipos y recursos desde una sola plataforma moderna e intuitiva.</p>
                </div>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">🏗️</div>
                        <span class="feature-text">Proyectos</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">📊</div>
                        <span class="feature-text">Reportes</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">👥</div>
                        <span class="feature-text">Equipos</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="login-card">
                <div class="login-header">
                    <h2>Iniciar Sesión</h2>
                    <p>Ingresa tus credenciales para continuar</p>
                </div>
                @if ($errors->any())
  <div style="
      background:#fee2e2;
      color:#b91c1c;
      border:1px solid #fca5a5;
      padding:12px 16px;
      border-radius:8px;
      margin-bottom:20px;
      font-weight:600;">
    <ul style="list-style:none; margin:0; padding:0;">
      @foreach ($errors->all() as $error)
        <li>⚠️ {{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <div class="input-wrapper">
            <span class="input-icon">📧</span>
            <input
                type="email"
                id="email"
                name="email"                {{-- <- nombre que espera Laravel --}}
                class="form-control"
                placeholder="tu@email.com"
                value="{{ old('email') }}"  {{-- <- repuebla si hay error --}}
                required
                autofocus
                autocomplete="username"
            >
        </div>
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input
                type="password"
                id="password"
                name="password"             {{-- <- nombre que espera Laravel --}}
                class="form-control"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            >
        </div>
    </div>

    <div class="form-options">
        <div class="remember-me">
            <input type="checkbox" id="remember" name="remember"> {{-- <- importante --}}
            <label for="remember">Recuérdame</label>
        </div>

        {{-- Enlace de “Olvidaste tu contraseña” si activaste password reset en Breeze --}}
        <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
    </div>

    <button type="submit" class="btn-login">Iniciar Sesión</button>

    <div class="footer-text">
        ¿Eres nuevo? <a href="{{ route('new-register') }}">Registra tu contreña</a>
    </div>
</form>

            </div>
        </div>
    </div>
</body>
</html>