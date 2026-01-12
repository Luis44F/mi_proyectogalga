<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Principal | GALGA</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Estilos -->
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/chat-dashboard.css') }}">
</head>

<body>

<!-- NAVBAR MOBILE -->
<nav class="navbar navbar-dark bg-dark d-md-none px-3">
    <button class="btn text-light" id="btnMenu">
        <i class="bi bi-list fs-3"></i>
    </button>
    <span class="navbar-brand fw-bold">GALGA</span>
</nav>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-circle">G</div>
        <span class="logo-text">GALGA</span>
    </div>

    <span class="menu-title">PRINCIPAL</span>

    <a href="{{ route('dashboard') }}" class="menu-item active">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="#mensajes" class="menu-item">
        <i class="bi bi-chat-dots"></i>
        Mensajería
    </a>

    <span class="menu-title">MÓDULOS</span>

    <a class="menu-item disabled">
        <i class="bi bi-box-seam"></i>
        Inventario <small>Próx.</small>
    </a>

    <a class="menu-item disabled">
        <i class="bi bi-people"></i>
        Personal <small>Próx.</small>
    </a>

    <div class="sidebar-footer">
        <a href="{{ route('login') }}" class="menu-item logout">
            <i class="bi bi-box-arrow-right"></i>
            Cerrar sesión
        </a>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

<h1 class="mb-4 fw-bold">Panel Principal</h1>

@php
    $user = auth()->user();
@endphp

<!-- ================= DASHBOARD POR PERFIL ================= -->

{{-- 👑 ADMINISTRADOR GENERAL --}}
@if($user->isAdmin())
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-galga text-center">
            <div>📄 Papeletas</div>
            <div class="metric-blue">{{ $totalPapeletas }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-galga text-center">
            <div>⏳ Pendientes</div>
            <div class="metric-yellow">{{ $lotesPendientes }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-galga text-center">
            <div>⚙️ En proceso</div>
            <div class="metric-blue">{{ $lotesProceso }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-galga text-center">
            <div>✅ Terminados</div>
            <div class="metric-green">{{ $lotesTerminados }}</div>
        </div>
    </div>
</div>
@endif

{{-- 👑 ADMINISTRACIÓN --}}
@if($user->isAdmin())
<div class="card-galga mb-4">
    <h5 class="fw-bold">👑 Administración de usuarios</h5>

    @foreach($users as $u)
    <form method="POST"
          action="{{ route('admin.usuario.rol', $u) }}"
          class="d-flex align-items-center gap-2 mb-2">
        @csrf

        <strong>{{ $u->nombre_completo }}</strong>

        <select name="rol" class="form-select form-select-sm w-auto">
            <option value="Administrador" {{ $u->rol=='Administrador'?'selected':'' }}>Administrador</option>
            <option value="Supervisor" {{ $u->rol=='Supervisor'?'selected':'' }}>Supervisor</option>
            <option value="Operario" {{ $u->rol=='Operario'?'selected':'' }}>Operario</option>
        </select>

        <button class="btn btn-sm btn-galga">Guardar</button>
    </form>
    @endforeach
</div>
@endif


{{-- 🧵 TEJEDORA --}}
@if($user->isTejedora())
<div class="row mb-4">
    <div class="col-12">
        <div class="card-galga">
            <h5 class="fw-bold">🧶 Papeletas para Tejido</h5>
            <p class="mb-1">Total disponibles: <strong>{{ $totalPapeletas }}</strong></p>
            <small class="text-muted">Solo visualización</small>
        </div>
    </div>
</div>
@endif

{{-- 🧭 SUPERVISORES --}}
@if($user->isSupervisor())
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-galga text-center">
            <div>⏳ Pendientes</div>
            <div class="metric-yellow">{{ $lotesPendientes }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-galga text-center">
            <div>⚙️ En proceso</div>
            <div class="metric-blue">{{ $lotesProceso }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-galga text-center">
            <div>✅ Terminados</div>
            <div class="metric-green">{{ $lotesTerminados }}</div>
        </div>
    </div>
</div>
@endif

{{-- 🏭 PRODUCCIÓN --}}
@if($user->isProduccion())
<div class="row mb-4">
    <div class="col-12">
        <div class="card-galga">
            <h5 class="fw-bold">🏭 Producción</h5>
            <p class="mb-0">Seguimiento de lotes asignados a tu área</p>
        </div>
    </div>
</div>
@endif

<!-- ================= MÉTRICAS ================= -->

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-galga text-center">
            <div>Mensajes nuevos</div>
            <div class="metric-blue">
                {{ $messages->where('leido',0)->count() }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-galga text-center">
            <div>Usuarios registrados</div>
            <div class="metric-green">
                {{ $users->count() + 1 }}
            </div>
        </div>
    </div>
</div>

<!-- ================= MENSAJERÍA ================= -->

<div class="card-galga p-0" id="mensajes">
<div class="chat-container">

<!-- USUARIOS -->
<div class="chat-users {{ request('user') ? 'd-none d-md-block' : '' }}">
@foreach($users as $u)
<a href="{{ route('dashboard',['user'=>$u->id]) }}"
   class="chat-user {{ request('user')==$u->id?'active':'' }}">
    <div class="chat-avatar">
        {{ strtoupper(substr($u->nombre_completo,0,1)) }}
    </div>
    <div>
        <strong>{{ $u->nombre_completo }}</strong><br>
        <small class="text-muted">
            {{ $u->rol }}

        </small>
    </div>
</a>
@endforeach
</div>

<!-- CHAT -->
<!-- CHAT -->
<div class="chat-area {{ request('user') ? '' : 'd-none d-md-flex' }}">

@if($selectedUser)

<!-- HEADER -->
<div class="chat-header">
    <a href="{{ route('dashboard') }}" class="btn btn-light d-md-none me-2">
        <i class="bi bi-arrow-left"></i>
    </a>

    <div class="chat-avatar me-2">
        {{ strtoupper(substr($selectedUser->nombre_completo,0,1)) }}
    </div>

    <div>
        <strong>{{ $selectedUser->nombre_completo }}</strong><br>
        <small class="text-muted">
            {{ $selectedUser->rol }}
        </small>
    </div>
</div>

<!-- MENSAJES -->
<div class="chat-messages" id="chatMessages">
@foreach($conversation as $msg)
<div class="message {{ $msg->emisor_id == auth()->id() ? 'sent' : 'received' }}">

    <div class="message-text">
        {{ $msg->mensaje }}
    </div>

    @if($msg->archivo_adj)
        <div class="message-file">
            <a href="{{ asset('storage/'.$msg->archivo_adj) }}" target="_blank">
                📎 {{ $msg->archivo_nombre_original }}
            </a>
        </div>
    @endif

    <div class="message-time">
        {{ $msg->created_at->format('H:i') }}
    </div>

</div>
@endforeach
</div>

<!-- INPUT -->
<form action="{{ route('mensajes.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="chat-input">
@csrf

<input type="hidden" name="receptor_id" value="{{ $selectedUser->id }}">

<label for="archivo_adj" class="chat-clip">
    <i class="bi bi-paperclip"></i>
</label>

<input type="file" name="archivo_adj" id="archivo_adj" hidden>

<input type="text"
       name="mensaje"
       class="form-control custom-input"
       placeholder="Escribe un mensaje…"
       required>

<button class="btn btn-galga" type="submit">
    <i class="bi bi-send"></i>
</button>
</form>

@else
<div class="d-flex h-100 justify-content-center align-items-center text-muted">
    Selecciona un usuario para comenzar
</div>
@endif

</div>

<!-- ================= SCRIPTS ================= -->
<script>
document.getElementById('btnMenu')?.addEventListener('click',()=>{
    document.getElementById('sidebar').classList.toggle('sidebar-active');
});

const chat=document.getElementById('chatMessages');
if(chat) chat.scrollTop=chat.scrollHeight;
</script>

</body>
</html>
