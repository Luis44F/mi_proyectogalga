<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Dashboard')</title>

    <!-- Tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #0b1e39;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            position: fixed;
            height: 100%;
            box-shadow: 3px 0 8px rgba(0,0,0,0.2);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .menu-item {
            padding: 14px 25px;
            cursor: pointer;
            transition: .2s;
            font-size: 15px;
            color: #d1d9e6;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        /* CONTENIDO */
        .content {
            margin-left: 240px;
            padding: 30px;
            width: calc(100% - 240px);
        }

        /* NAVBAR */
        .navbar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .navbar .user {
            font-weight: 500;
            color: #333;
        }

        /* TARJETAS */
        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .title {
            font-size: 22px;
            font-weight: 600;
            color: #0b1e39;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>G A L G A</h2>

        <div class="menu-item">🏠 Dashboard</div>
        <div class="menu-item">📁 Fichas Técnicas</div>
        <div class="menu-item">🧵 Programación Tejido</div>
        <div class="menu-item">🛠 Producción</div>
        <div class="menu-item">📦 Distribución</div>
        <div class="menu-item">💬 Mensajes</div>
        <div class="menu-item">👤 Mi Perfil</div>
        <div class="menu-item">🚪 Cerrar Sesión</div>
    </div>

    <!-- CONTENIDO -->
    <div class="content">
        <div class="navbar">
            <div class="title">@yield('titulo')</div>
            <div class="user">Hola, {{ Auth::user()->nombre_completo ?? 'Usuario' }}</div>
        </div>

        @yield('contenido')
    </div>

</body>
</html>
