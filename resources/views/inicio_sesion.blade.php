<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- NECESARIO PARA EVITAR EL 419 -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Iniciar Sesión | GALGA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center" style="height:100vh">
  <div class="card shadow" style="width:380px;">
    <div class="card-body p-4">
      <div class="text-center mb-3">
        <img src="{{ asset('img/GalgaLogo.png') }}" height="60" alt="GALGA">
        <h4 class="mt-3">Iniciar sesión</h4>
      </div>

      <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        @if ($errors->any())
          <div class="alert alert-danger">
            {{ $errors->first() }}
          </div>
        @endif

        <div class="mb-3">
          <label class="form-label">Correo institucional</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Acceder</button>
      </form>

      <div class="text-center mt-3">
        <a href="{{ route('crear.cuenta') }}">Crear cuenta</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
