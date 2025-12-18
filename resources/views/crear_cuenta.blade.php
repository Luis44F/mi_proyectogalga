<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- NECESARIO PARA EVITAR 419 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Crear Cuenta | GALGA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

            <form action="{{ route('registrar') }}" method="POST">
                @csrf

                <label>Nombre completo</label>
                <input type="text" name="nombre_completo" placeholder="Ingrese nombre completo" required>

                <label>Correo electrónico</label>
                <input type="email" name="email" placeholder="ejemplo@galga.com" required>

                <label>Contraseña</label>
                <input type="password" name="password" placeholder="********" required>

                <label>Teléfono</label>
                <input type="text" name="telefono" placeholder="Opcional">

                <label>Rol de usuario</label>
                <select name="rol" required>
                    <option value="">Seleccione un rol</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Operario">Operario</option>
                </select>

                <button type="submit" class="btn-crear mt-2">Crear Cuenta</button>
            </form>

            <p class="text-center mt-3 small text-light">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="btn-link-login">Iniciar sesión</a>
            </p>

        </div>
    </div>

</body>
</html>
