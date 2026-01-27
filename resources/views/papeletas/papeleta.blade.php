<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Producción | Papeleta #{{ $papeleta->id }}</title>
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; border-radius: 12px 12px 0 0 !important; padding: 1.2rem; }
        .label-text { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600; }
        .value-text { font-size: 1.1rem; font-weight: 500; color: #212529; }
        .status-badge { padding: 0.5em 1em; border-radius: 50rem; font-weight: 600; font-size: 0.9rem; }
    </style>
</head>
<body class="container py-5">

    {{-- 🧪 DEBUGGER (Solo para ver si detecta tu rol, elimínalo luego) --}}
    <div class="alert alert-light border shadow-sm d-flex justify-content-between align-items-center mb-4 py-2">
        <small class="text-muted"><i class="bi bi-bug-fill me-1"></i> Debug Info</small>
        <div class="d-flex gap-3 small">
            <span>👤 Rol: <strong>{{ auth()->user()->rol }}</strong></span>
            <span>📄 Estado: <strong>{{ $papeleta->estado }}</strong></span>
        </div>
    </div>

    {{-- ENCABEZADO PRINCIPAL --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>Papeleta #{{ $papeleta->id }}
            </h2>
            <p class="text-muted mb-0">Gestión y control de producción</p>
        </div>
        
        {{-- Badge de Estado --}}
        <div>
            @if($papeleta->estado === 'AUTORIZADA')
                <span class="badge bg-success bg-opacity-10 text-success border border-success status-badge">
                    <i class="bi bi-check-circle-fill me-1"></i> AUTORIZADA
                </span>
            @elseif($papeleta->estado === 'DETENIDA')
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger status-badge">
                    <i class="bi bi-exclamation-octagon-fill me-1"></i> DETENIDA
                </span>
            @else
                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary status-badge">
                    <i class="bi bi-hourglass-split me-1"></i> {{ $papeleta->estado }}
                </span>
            @endif
        </div>
    </div>

    <div class="row g-4">
        
        {{-- COLUMNA IZQUIERDA: INFORMACIÓN Y LISTA --}}
        <div class="col-lg-8">
            
            {{-- TARJETA DE INFORMACIÓN TÉCNICA --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold text-dark">📋 Ficha Técnica</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="label-text">Cliente</div>
                            <div class="value-text">{{ $papeleta->cliente }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="label-text">Modelo</div>
                            <div class="value-text">{{ $papeleta->modelo }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="label-text">Marca</div>
                            <div class="value-text">{{ $papeleta->marca ?? '—' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="label-text">Talla</div>
                            <div class="value-text">{{ $papeleta->talla ?? '—' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="label-text">Piezas Totales</div>
                            <div class="value-text text-primary">{{ $papeleta->piezas_totales }}</div>
                        </div>
                        
                        {{-- Sección de Autorización (Visible si ya fue autorizada) --}}
                        @if($papeleta->estado === 'AUTORIZADA' && $papeleta->autorizadoPor)
                            <div class="col-12 mt-4">
                                <div class="p-3 rounded bg-success bg-opacity-10 border border-success border-opacity-25 d-flex align-items-center gap-3">
                                    <div class="fs-1 text-success"><i class="bi bi-patch-check-fill"></i></div>
                                    <div>
                                        <div class="text-success fw-bold text-uppercase small">Autorizado Oficialmente</div>
                                        <div class="fw-bold text-dark">{{ $papeleta->autorizadoPor->nombre_completo ?? $papeleta->autorizadoPor->name }}</div>
                                        <small class="text-muted">
                                            {{ $papeleta->autorizado_en ? $papeleta->autorizado_en->format('d/m/Y • H:i') : '' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- HISTORIAL DE LOTES --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">📦 Historial de Lotes</h5>
                    <span class="badge bg-secondary rounded-pill">{{ $papeleta->lotes->count() }} lotes</span>
                </div>
                <div class="card-body p-0">
                    @if($papeleta->lotes->count())
                        <div class="list-group list-group-flush">
                            @foreach($papeleta->lotes as $lote)
                                <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-circle p-2 text-primary">
                                            <i class="bi bi-box-seam fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Lote #{{ $lote->id }}</h6>
                                            <small class="text-muted">{{ $lote->cantidad }} piezas registradas</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill">
                                        {{ $lote->estado ?? 'EN PRODUCCIÓN' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box2 text-muted fs-1 opacity-50"></i>
                            <p class="text-muted mt-2">No se han generado lotes aún.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- COLUMNA DERECHA: ACCIONES Y DECISIONES --}}
        <div class="col-lg-4">
            
            {{-- 1️⃣ ZONA DE DECISIÓN: AUTORIZAR / DETENER (Solo si está CREADA) --}}
            @if(auth()->user()->rol === 'Administrador' && $papeleta->estado === 'CREADA')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body bg-warning bg-opacity-10 rounded-3 p-4 border border-warning border-opacity-25">
                        <h5 class="fw-bold text-dark mb-3">
                            <i class="bi bi-shield-exclamation me-2"></i>Requiere Revisión
                        </h5>
                        <p class="small text-muted mb-4">Como administrador, debes validar esta papeleta antes de iniciar producción.</p>
                        
                        <div class="d-grid gap-2">
                            {{-- Botón AUTORIZAR --}}
                            <form method="POST" action="{{ route('papeletas.autorizar', $papeleta->id) }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                                    <i class="bi bi-check-lg me-1"></i> Autorizar Papeleta
                                </button>
                            </form>

                            {{-- Botón DETENER --}}
                            <form method="POST" action="{{ route('papeletas.detener', $papeleta->id) }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-danger w-100 py-2 fw-bold shadow-sm">
                                    <i class="bi bi-x-lg me-1"></i> Detener
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            {{-- 2️⃣ ZONA DE ACCIÓN: CREAR LOTE (Solo si está AUTORIZADA) --}}
            @if((auth()->user()->rol === 'Administrador General' || auth()->user()->rol === 'Administrador') && $papeleta->estado === 'AUTORIZADA')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body bg-primary bg-gradient text-white rounded-3 p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle-dotted me-2"></i>Nuevo Lote</h5>
                        <p class="small text-white-50 mb-3">Genere un nuevo lote de producción vinculado a esta papeleta.</p>
                        
                        <form method="POST" action="{{ route('lotes.store') }}">
                            @csrf
                            <input type="hidden" name="papeleta_id" value="{{ $papeleta->id }}">

                            <div class="mb-3">
                                <label class="form-label text-white small fw-bold">CANTIDAD A PRODUCIR</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 text-primary"><i class="bi bi-123"></i></span>
                                    <input type="number" name="cantidad" class="form-control border-0" required min="1" placeholder="Ej. 50">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-light text-primary fw-bold w-100 py-2 shadow-sm">
                                Crear Lote
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Resumen Informativo --}}
            <div class="card">
                <div class="card-body">
                    <small class="text-muted fw-bold text-uppercase">Información del sistema</small>
                    <ul class="list-unstyled mt-3 mb-0 small text-secondary">
                        <li class="mb-2"><i class="bi bi-calendar3 me-2"></i> Creado: {{ $papeleta->created_at->format('d/m/Y') }}</li>
                        <li class="mb-2"><i class="bi bi-person me-2"></i> Cliente: {{ $papeleta->cliente }}</li>
                        <li><i class="bi bi-flag me-2"></i> Prioridad: Normal</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>