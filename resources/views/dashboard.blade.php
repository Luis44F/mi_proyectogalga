<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal | GALGA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat-dashboard.css') }}">
</head>

<body>

<nav class="navbar navbar-dark d-md-none px-3">
    <button class="btn text-light" id="btnMenu">
        <i class="bi bi-list fs-3"></i>
    </button>
    <span class="navbar-brand fw-bold">GALGA</span>
</nav>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-circle">G</div>
        <div class="d-flex flex-column">
            <span class="logo-text">GALGA</span>
            <small class="text-muted" style="font-size: 10px;">System Manager</small>
        </div>
    </div>

    <span class="menu-title">PRINCIPAL</span>

    <a href="{{ route('dashboard') }}" class="menu-item active">
        <i class="bi bi-grid-1x2-fill"></i>
        Dashboard
    </a>

    <a href="#mensajes" class="menu-item">
        <i class="bi bi-chat-dots-fill"></i>
        Mensajería
        @if($messages->where('leido',0)->count() > 0)
            <span class="badge bg-danger rounded-circle ms-auto" style="font-size: 8px;">•</span>
        @endif
    </a>

    <span class="menu-title">MÓDULOS</span>

    {{-- 1️⃣ NUEVO LINK EN EL SIDEBAR --}}
    <a href="{{ route('produccion.flujo') }}" class="menu-item">
        <i class="bi bi-diagram-3-fill"></i>
        Flujo de Producción
    </a>

    
    <a href="{{ route('papeleta.ver') }}" class="menu-item">
         <i class="bi bi-file-earmark-text-fill"></i>
         Ver Papeleta
    </a>


    @if(auth()->user()->rol === 'Administrador')
        <a href="{{ route('papeletas.create') }}" class="menu-item">
            <i class="bi bi-file-earmark-plus-fill"></i>
            Crear Papeleta
        </a>
    @endif

    <a class="menu-item disabled">
        <i class="bi bi-box-seam-fill"></i>
        Inventario <small>Próx.</small>
    </a>

    <a class="menu-item disabled">
        <i class="bi bi-people-fill"></i>
        Personal <small>Próx.</small>
    </a>

    <div class="sidebar-footer">
        <a href="{{ route('login') }}" class="menu-item logout">
            <i class="bi bi-box-arrow-right"></i>
            Cerrar sesión
        </a>
    </div>
</div>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold m-0">Hola, {{ auth()->user()->nombre_completo }}</h1>
            <p class="text-muted m-0">Bienvenido a tu panel de control</p>
        </div>
        <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
            {{ auth()->user()->rol }}
        </span>
    </div>

    @php $user = auth()->user(); @endphp

    {{-- 👑 ADMINISTRADOR GENERAL --}}
    @if($user->isAdmin())
    
    {{-- MÉTRICAS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-galga card-metric">
                <div class="metric-icon bg-blue-light text-blue">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Papeletas</div>
                    <div class="metric-value text-blue">{{ $totalPapeletas }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-galga card-metric">
                <div class="metric-icon bg-yellow-light text-yellow">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Pendientes</div>
                    <div class="metric-value text-yellow">{{ $lotesPendientes }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-galga card-metric">
                <div class="metric-icon bg-blue-light text-blue">
                    <i class="bi bi-gear-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">En proceso</div>
                    <div class="metric-value text-blue">{{ $lotesProceso }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-galga card-metric">
                <div class="metric-icon bg-green-light text-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-bold text-uppercase">Terminados</div>
                    <div class="metric-value text-green">{{ $lotesTerminados }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2️⃣ NUEVA SECCIÓN: GESTIÓN DE PAPELETAS --}}
    {{-- Se usa card-galga en lugar de card para mantener el estilo visual --}}
    @if(isset($papeletas) && count($papeletas) > 0)
        <h5 class="fw-bold mb-3 text-muted text-uppercase small">📦 Acciones Rápidas</h5>
        @foreach($papeletas as $papeleta)
        <div class="card-galga mb-3">
            <div class="p-3 d-flex justify-content-between align-items-center">

                <div>
                    <strong class="text-primary"><i class="bi bi-file-text me-1"></i> Papeleta #{{ $papeleta->id }}</strong><br>
                    <span class="text-muted small">{{ $papeleta->modelo }}</span>
                </div>

                <a href="{{ route('lotes.index', $papeleta->id) }}"
                   class="btn btn-outline-primary rounded-pill btn-sm px-4 fw-bold">
                    Gestionar lotes <i class="bi bi-arrow-right ms-1"></i>
                </a>

            </div>
        </div>
        @endforeach
        <hr class="my-4 text-muted opacity-25">
    @endif
    {{-- FIN NUEVA SECCIÓN --}}

    @endif

    {{-- 👑 ADMINISTRACIÓN USUARIOS --}}
    @if($user->isAdmin())
    <div class="card-galga mb-4">
        <div class="card-header-clean">
            <h5 class="fw-bold m-0"><i class="bi bi-shield-lock-fill me-2 text-warning"></i>Administración de usuarios</h5>
        </div>
        <div class="p-3">
            @foreach($users as $u)
            <form method="POST" action="{{ route('admin.usuario.rol', $u) }}" class="user-row d-flex align-items-center justify-content-between p-2 rounded mb-1">
                @csrf
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm">{{ substr($u->nombre_completo, 0, 1) }}</div>
                    <strong class="text-dark">{{ $u->nombre_completo }}</strong>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <select name="rol" class="form-select form-select-sm border-0 bg-light fw-bold" style="width: 140px;">
                        <option value="Administrador" {{ $u->rol=='Administrador'?'selected':'' }}>Administrador</option>
                        <option value="Supervisor" {{ $u->rol=='Supervisor'?'selected':'' }}>Supervisor</option>
                        <option value="Operario" {{ $u->rol=='Operario'?'selected':'' }}>Operario</option>
                    </select>
                    <button class="btn btn-sm btn-icon"><i class="bi bi-check-lg"></i></button>
                </div>
            </form>
            @endforeach
        </div>
    </div>
    @endif

    {{-- 🧵 TEJEDORA --}}
    @if($user->isTejedora())
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-galga p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark">🧶 Papeletas para Tejido</h5>
                    <p class="mb-0 text-muted">Gestión de asignaciones activas</p>
                </div>
                <div class="text-end">
                    <div class="display-4 fw-bold text-blue">{{ $totalPapeletas }}</div>
                    <small class="text-muted">Disponibles</small>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 🏭 PRODUCCIÓN --}}
    @if($user->isProduccion())
    <div class="card-galga mb-4 p-4 text-center border-dashed">
        <div class="mb-3 text-muted display-6"><i class="bi bi-buildings"></i></div>
        <h5 class="fw-bold">Área de Producción</h5>
        <p class="text-muted">Selecciona un lote del menú para comenzar el seguimiento.</p>
    </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-galga p-3 d-flex align-items-center gap-3">
                <div class="metric-icon bg-indigo-light text-indigo">
                    <i class="bi bi-chat-square-text-fill"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $messages->where('leido',0)->count() }}</div>
                    <div class="text-muted small">Mensajes nuevos</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-galga p-3 d-flex align-items-center gap-3">
                <div class="metric-icon bg-teal-light text-teal">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $users->count() + 1 }}</div>
                    <div class="text-muted small">Usuarios totales</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-galga p-0 overflow-hidden shadow-lg" id="mensajes">
        <div class="chat-container">

            <div class="chat-users {{ request('user') ? 'd-none d-md-block' : '' }}">
                <div class="p-3 border-bottom bg-light">
                    <small class="fw-bold text-uppercase text-muted">Conversaciones</small>
                </div>
                @foreach($users as $u)
                <a href="{{ route('dashboard',['user'=>$u->id]) }}" class="chat-user {{ request('user')==$u->id ? 'active' : '' }}">
                    <div class="chat-avatar">
                        {{ strtoupper(substr($u->nombre_completo, 0, 1)) }}
                        <span class="online-dot"></span>
                    </div>
                    <div class="chat-user-info">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $u->nombre_completo }}</strong>
                            @if($u->unread_count > 0)
                                <span class="badge bg-danger rounded-pill">{{ $u->unread_count }}</span>
                            @endif
                        </div>
                        <small class="text-muted text-truncate d-block" style="max-width: 140px;">
                            {{ $u->lastMessage->mensaje ?? $u->rol }}
                        </small>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="chat-area {{ request('user') ? '' : 'd-none d-md-flex' }}">
                @if($selectedUser)
                    <div class="chat-header">
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light rounded-circle d-md-none me-2">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <div class="chat-avatar me-3" style="width: 38px; height: 38px; font-size: 14px;">
                            {{ strtoupper(substr($selectedUser->nombre_completo,0,1)) }}
                        </div>
                        <div>
                            <h6 class="m-0 fw-bold">{{ $selectedUser->nombre_completo }}</h6>
                            <small class="text-success"><i class="bi bi-circle-fill" style="font-size: 8px;"></i> {{ $selectedUser->rol }}</small>
                        </div>
                    </div>

                    <div class="chat-messages" id="chatMessages" data-user="{{ $selectedUser->id }}">
                        
                        <div class="text-center my-3">
                            <small class="text-muted bg-white px-3 py-1 rounded-pill shadow-sm">Inicio de la conversación</small>
                        </div>
                        
                        @foreach($conversation as $msg)
                        <div class="message {{ $msg->emisor_id == auth()->id() ? 'sent' : 'received' }}">
                            <div class="message-content">
                                @if($msg->archivo_adj)
                                    <a href="{{ asset('storage/'.$msg->archivo_adj) }}" target="_blank" class="file-attachment">
                                        <div class="icon"><i class="bi bi-file-earmark-arrow-down"></i></div>
                                        <div class="name">{{ $msg->archivo_nombre_original }}</div>
                                    </a>
                                @endif
                                
                                <div class="message-text">
                                    {{ $msg->mensaje }}
                                </div>

                                <div class="message-time d-flex justify-content-end align-items-center gap-1">
                                    <span>{{ $msg->created_at->format('H:i') }}</span>
                                    
                                    @if($msg->emisor_id === auth()->id())
                                        @if($msg->leido)
                                            <i class="bi bi-check2-all text-primary"></i>
                                        @else
                                            <i class="bi bi-check2-all text-muted"></i>
                                        @endif
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <form action="{{ route('mensajes.store') }}" method="POST" enctype="multipart/form-data" class="chat-input-area">
                        @csrf
                        <input type="hidden" name="receptor_id" value="{{ $selectedUser->id }}">
                        
                        <div class="input-wrapper">
                            <label for="archivo_adj" class="btn-clip" title="Adjuntar">
                                <i class="bi bi-paperclip"></i>
                            </label>
                            <input type="file" name="archivo_adj" id="archivo_adj" hidden>
                            
                            <input type="text" name="mensaje" class="form-control border-0" placeholder="Escribe un mensaje..." required autocomplete="off">
                            
                            <button class="btn-send" type="submit">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="d-flex flex-column h-100 justify-content-center align-items-center text-muted bg-light">
                        <div class="fs-1 text-muted opacity-25 mb-3"><i class="bi bi-chat-dots"></i></div>
                        <p>Selecciona un chat para comenzar</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById('btnMenu')?.addEventListener('click',()=>{
        document.getElementById('sidebar').classList.toggle('sidebar-active');
    });

    // --- LÓGICA DE ACTUALIZACIÓN EN TIEMPO REAL ---
    const chatBox = document.getElementById('chatMessages');
    
    // Inicializamos con el conteo actual para evitar parpadeos innecesarios al cargar
    let lastCount = {{ isset($conversation) ? $conversation->count() : 0 }};

    function fetchMessages() {
        if (!chatBox) return;

        const userId = chatBox.dataset.user;
        if (!userId) return;

        fetch(`/mensajes/fetch/${userId}`)
            .then(r => r.json())
            .then(messages => {
                if (messages.length === lastCount) {
                    // Aquí podrías agregar lógica extra si quisieras
                }
                
                lastCount = messages.length;
                chatBox.innerHTML = '';
                
                // Mantenemos el header de inicio
                chatBox.innerHTML += '<div class="text-center my-3"><small class="text-muted bg-white px-3 py-1 rounded-pill shadow-sm">Inicio de la conversación</small></div>';

                messages.forEach(msg => {
                    const mine = msg.emisor_id == {{ auth()->id() }};
                    let checks = '';

                    if (mine) {
                        checks = msg.leido
                            ? '<i class="bi bi-check2-all text-primary"></i>'
                            : '<i class="bi bi-check2-all text-muted"></i>';
                    }

                    let attachmentHtml = '';
                    if(msg.archivo_adj) {
                         attachmentHtml = `
                            <a href="/storage/${msg.archivo_adj}" target="_blank" class="file-attachment">
                                <div class="icon"><i class="bi bi-file-earmark-arrow-down"></i></div>
                                <div class="name">${msg.archivo_nombre_original || 'Archivo'}</div>
                            </a>`;
                    }

                    chatBox.innerHTML += `
                        <div class="message ${mine ? 'sent' : 'received'}">
                            <div class="message-content">
                                ${attachmentHtml}
                                <div class="message-text">${msg.mensaje}</div>
                                <div class="message-time d-flex justify-content-end align-items-center gap-1">
                                    <span>${msg.created_at.substring(11,16)}</span>
                                    ${checks}
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    }

    setInterval(fetchMessages, 3000);
    if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>

</body>
</html>