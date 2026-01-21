<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- NECESARIO PARA EVITAR 419 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Crear Cuenta | GALGA</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tu CSS -->
    <link rel="stylesheet" href="{{ asset('css/crear_cuenta.css') }}">
</head>

<body class="registro-body">

<div class="registro-overlay">
    <div class="registro-card">

        <div class="text-center mb-4">
            <img src="{{ asset('img/GalgaLogo.png') }}" class="registro-logo">
            <h2 class="mt-3">Crear Cuenta</h2>
            <p>Registra un nuevo usuario en el sistema</p>
        </div>

        <!-- 🔴 MOSTRAR ERRORES -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registrar') }}" method="POST" novalidate>
            @csrf

            <label>Nombre completo</label>
            <input type="text" name="nombre_completo"
                   value="{{ old('nombre_completo') }}"
                   placeholder="Ingrese nombre completo" required>

            <label>Correo electrónico</label>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="ejemplo@galga.com"
                   autocomplete="off"
                   required>

            <!-- CONTRASEÑA -->
            <label>Contraseña</label>
            <div class="password-wrapper">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="********"
                    autocomplete="new-password"
                    required
                >
                <button type="button" class="toggle-password" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <label>Teléfono</label>
            <input type="tel"
                   name="telefono"
                   value="{{ old('telefono') }}"
                   placeholder="Opcional"
                   autocomplete="off">

            <label>Rol de usuario</label>
            <select name="rol" required>
                <option value="">Seleccione un rol</option>
                <option value="Administrador" {{ old('rol')=='Administrador'?'selected':'' }}>Administrador</option>
                <option value="Supervisor" {{ old('rol')=='Supervisor'?'selected':'' }}>Supervisor</option>
                <option value="Operario" {{ old('rol')=='Operario'?'selected':'' }}>Operario</option>
            </select>

            <button type="submit" class="btn-crear mt-2">Crear Cuenta</button>
        </form>

        <p class="text-center mt-3 small text-light">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}" class="btn-link-login">Iniciar sesión</a>
        </p>

    </div>
</div>

<!-- SCRIPT VER / OCULTAR CONTRASEÑA -->
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>
