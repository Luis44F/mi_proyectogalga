<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GALGA | Plataforma Digital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/Index.css">
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-galga fixed-top py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <div class="logo-icon">G</div>
        <span class="logo-text">GALGA</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center gap-2">
          <li class="nav-item">
            <a class="nav-link" href="#funciones">Funciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#vista-general">Vista general</a>
          </li>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-primary-galga" href="{{ route('crear.cuenta') }}">Crea una cuenta</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero-section">
    <div class="hero-bg-elements">
      <div class="floating-circle circle-1"></div>
      <div class="floating-circle circle-2"></div>
      <div class="floating-circle circle-3"></div>
    </div>
    <div class="container position-relative">
      <div class="hero-content text-center animate-fade-in">
        <span class="hero-badge">Sistema Integral de Gestión</span>
        <h1 class="hero-title">Plataforma Digital <span class="text-gradient">GALGA</span></h1>
        <p class="hero-subtitle">Optimización, control y productividad para la industria textil. Transforma tu operación con tecnología de vanguardia.</p>
        <div class="hero-buttons">
          <a href="/login" class="btn btn-hero-primary">
            <span>Entrar al sistema</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
          <a href="#funciones" class="btn btn-hero-secondary">Conocer más</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FUNCIONES -->
  <section id="funciones" class="features-section">
    <div class="container">
      <div class="section-header text-center animate-fade-in">
        <span class="section-badge">Características</span>
        <h2 class="section-title">Funciones Principales</h2>
        <p class="section-subtitle">Herramientas diseñadas para maximizar la eficiencia de tu operación textil</p>
      </div>

      <div class="row g-4 mt-4">
        <!-- Card 1 -->
        <div class="col-md-6 col-lg-4 animate-fade-in delay-1">
          <div class="feature-card">
            <div class="feature-icon icon-blue">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            </div>
            <h4 class="feature-title">Control de Producción</h4>
            <p class="feature-description">Registro de avances, pedidos, tiempos y lotes en tiempo real con seguimiento detallado.</p>
            <div class="feature-link">
              <span>Explorar</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 col-lg-4 animate-fade-in delay-2">
          <div class="feature-card">
            <div class="feature-icon icon-emerald">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
            </div>
            <h4 class="feature-title">Dashboards Ejecutivos</h4>
            <p class="feature-description">Indicadores visuales KPI para decisiones rápidas, precisas y basadas en datos.</p>
            <div class="feature-link">
              <span>Explorar</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6 col-lg-4 animate-fade-in delay-3">
          <div class="feature-card">
            <div class="feature-icon icon-violet">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
            </div>
            <h4 class="feature-title">Automatización de Reportes</h4>
            <p class="feature-description">Exportación a PDF/Excel, notificaciones automáticas y reducción de errores humanos.</p>
            <div class="feature-link">
              <span>Explorar</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- VIDEO / VISTA GENERAL -->
  <section id="vista-general" class="video-section">
    <div class="container">
      <div class="section-header text-center animate-fade-in">
        <span class="section-badge">Demo</span>
        <h2 class="section-title">Vista General del Sistema</h2>
        <p class="section-subtitle">Descubre cómo GALGA puede transformar tu operación</p>
      </div>

      <div class="video-container animate-fade-in delay-2">
        <div class="video-wrapper">
          <div class="video-placeholder">
            <div class="play-button">
              <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </div>
            <p class="video-text">Vista previa del sistema</p>
          </div>
          <!-- Descomenta esto para usar video real -->
          <!-- <video class="video-element" controls>
            <source src="video/galga_video.mp4" type="video/mp4">
          </video> -->
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-card animate-fade-in">
        <h2 class="cta-title">¿Listo para optimizar tu producción?</h2>
        <p class="cta-subtitle">Únete a las empresas textiles que ya confían en GALGA</p>
        <a href="/login" class="btn btn-cta">
          <span>Comenzar ahora</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer-galga">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <div class="footer-logo">
            <div class="logo-icon logo-icon-sm">G</div>
            <span class="logo-text">GALGA</span>
          </div>
          <p class="footer-tagline">Plataforma digital para la industria textil</p>
        </div>
        <div class="footer-links">
          <a href="#funciones">Funciones</a>
          <a href="#vista-general">Vista General</a>
          <a href="/login">Acceder</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2025 GALGA | Sistema Interno</p>
        <p>Desarrollado por Luis Felipe Huerta · Estadías UTSG</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar-galga');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Animate on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, observerOptions);

    document.querySelectorAll('.animate-fade-in').forEach(el => {
      observer.observe(el);
    });
  </script>
</body>
</html>
