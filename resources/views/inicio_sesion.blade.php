<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Iniciar Sesión | GALGA</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/inicio_sesion.css') }}">
</head>

<body class="login-body">
  <!-- Elementos decorativos flotantes -->
  <div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
  </div>

  <!-- Contenedor principal -->
  <div class="login-container">
    <!-- Panel izquierdo - Branding -->
    <div class="login-branding">
      <div class="branding-content">
        <div class="logo-wrapper">
          <div class="logo-icon">
            <i class="bi bi-gear-wide-connected"></i>
          </div>
          <span class="logo-text">GALGA</span>
        </div>
        <h1 class="branding-title">Plataforma Digital</h1>
        <p class="branding-subtitle">Sistema integral de gestión para la industria textil</p>
        
        <div class="features-list">
          <div class="feature-item">
            <i class="bi bi-shield-check"></i>
            <span>Acceso seguro y encriptado</span>
          </div>
          <div class="feature-item">
            <i class="bi bi-graph-up-arrow"></i>
            <span>Dashboards en tiempo real</span>
          </div>
          <div class="feature-item">
            <i class="bi bi-cloud-check"></i>
            <span>Datos sincronizados 24/7</span>
          </div>
        </div>
      </div>
      
      <div class="branding-footer">
        <p>© 2025 GALGA · Todos los derechos reservados</p>
      </div>
    </div>

    <!-- Panel derecho - Formulario -->
    <div class="login-form-panel">
      <div class="login-card">
        <div class="card-header">
          <div class="welcome-icon">
            <i class="bi bi-person-circle"></i>
          </div>
          <h2>Bienvenido</h2>
          <p>Ingresa tus credenciales para continuar</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
          @csrf

          @if ($errors->any())
            <div class="error-alert">
              <i class="bi bi-exclamation-triangle-fill"></i>
              <span>{{ $errors->first() }}</span>
            </div>
          @endif

          <div class="form-group">
            <label for="email">
              <i class="bi bi-envelope"></i>
              Correo institucional
            </label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              class="form-input" 
              placeholder="usuario@empresa.com"
              value="{{ old('email') }}"
              required 
              autofocus
            >
          </div>

          <div class="form-group">
            <label for="password">
              <i class="bi bi-lock"></i>
              Contraseña
            </label>
            <div class="password-wrapper">
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-input" 
                placeholder="••••••••"
                required
              >
              <button type="button" class="toggle-password" onclick="togglePassword()">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </button>
            </div>
          </div>

          <div class="form-options">
            <label class="remember-me">
              <input type="checkbox" name="remember">
              <span class="checkmark"></span>
              Recordarme
            </label>
            <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="submit-btn">
            <span>Iniciar sesión</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>

        <div class="card-footer">
          <p>¿No tienes cuenta?</p>
          <a href="{{ route('crear.cuenta') }}" class="register-link">
            <i class="bi bi-person-plus"></i>
            Crear cuenta nueva
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
      }
    }

    // Animación de entrada
    document.addEventListener('DOMContentLoaded', function() {
      const elements = document.querySelectorAll('.form-group, .submit-btn, .card-footer');
      elements.forEach((el, index) => {
        el.style.animationDelay = `${0.1 * index}s`;
      });
    });
  </script>
</body>
</html>
