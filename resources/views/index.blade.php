<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GALGA | Plataforma Digital</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/Index.css') }}">
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg py-3 fixed-top navbar-galga">
    <div class="container">

      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('img/GalgaLogo.png') }}" alt="GALGA" class="logo-galga">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="#servicios">Funciones</a></li>
          <li class="nav-item"><a class="nav-link" href="#panel">Vista general</a></li>

          <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
            <!-- ✔️ Redirección corregida -->
            <button onclick="window.location.href='{{ url('/crear_cuenta') }}'" class="btn btn-primary px-4">
              Crea una cuenta
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header class="hero-section">
    <div class="hero-content">
      <h1 class="hero-title">Plataforma Digital GALGA</h1>
      <p class="hero-subtitle">Optimización, control y productividad para la industria textil.</p>

      <!-- ✔️ Ya tenías funcional la redirección al login -->
      <button class="btn btn-primary btn-lg mt-3 px-4" onclick="window.location.href='{{ url('/login') }}'">
        Entrar al sistema
      </button>
    </div>
  </header>

  <!-- SERVICIOS -->
  <main class="container py-5" id="servicios">
    <h2 class="section-title text-center mb-5">Funciones Principales</h2>

    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="service-card shadow-sm">
          <h4 class="fw-bold">Control de Producción</h4>
          <p class="mb-0">Registro de avances, pedidos, tiempos y lotes en tiempo real.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-card shadow-sm">
          <h4 class="fw-bold">Dashboards Ejecutivos</h4>
          <p class="mb-0">Indicadores visuales para decisiones rápidas y precisas.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-card shadow-sm">
          <h4 class="fw-bold">Automatización de Reportes</h4>
          <p class="mb-0">Exportación a PDF/Excel, notificaciones y reducción de errores.</p>
        </div>
      </div>
    </div>
  </main>

  <!-- VIDEO -->
  <section class="video-section py-5" id="panel">
    <div class="container text-center">
      <h2 class="section-title mb-4">Vista General del Sistema</h2>

      <video controls class="video-element">
        <source src="{{ asset('img/presentacion.mp4') }}" type="video/mp4">
        Tu navegador no soporta videos.
      </video>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer-galga text-center py-4">
    <p class="mb-1">© 2025 GALGA | Sistema Interno</p>
    <small>Desarrollado por Luis Felipe Huerta · Estadías UTSG</small>
  </footer>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- NAVBAR SCROLL SCRIPT -->
  <script>
    const navbar = document.querySelector('.navbar-galga');

    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>

</body>
</html>
