<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Producción | Papeleta #{{ $papeleta->id }}</title>
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --card-shadow: 0 10px 40px rgba(0,0,0,0.08);
            --card-shadow-hover: 0 20px 60px rgba(0,0,0,0.12);
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
        }

        .page-header {
            background: var(--dark-gradient);
            border-radius: 24px;
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .page-header h2 {
            color: #fff;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: rgba(255,255,255,0.6);
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .label-text {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .value-text {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1e293b;
        }

        .status-badge {
            padding: 0.75em 1.5em;
            border-radius: 50rem;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-badge.authorized {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(52, 211, 153, 0.15) 100%);
            color: #059669;
            border: 2px solid rgba(16, 185, 129, 0.3);
        }

        .status-badge.stopped {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(248, 113, 113, 0.15) 100%);
            color: #dc2626;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .status-badge.pending {
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.15) 0%, rgba(156, 163, 175, 0.15) 100%);
            color: #4b5563;
            border: 2px solid rgba(107, 114, 128, 0.3);
        }

        .info-card {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 1.25rem;
            border: 1px solid rgba(0,0,0,0.04);
        }

        .authorization-banner {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(52, 211, 153, 0.08) 100%);
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .authorization-banner .icon-wrapper {
            width: 56px;
            height: 56px;
            background: var(--success-gradient);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .lote-item {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            transition: all 0.2s ease;
        }

        .lote-item:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .lote-item:last-child {
            border-bottom: none;
        }

        .lote-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            font-size: 1.25rem;
        }

        .lote-badge {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(34, 211, 238, 0.1) 100%);
            color: #0891b2;
            border: 1.5px solid rgba(6, 182, 212, 0.25);
            padding: 0.4em 1em;
            border-radius: 50rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .decision-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid rgba(245, 158, 11, 0.3);
            border-radius: 20px;
            padding: 2rem;
        }

        .decision-card h5 {
            color: #92400e;
        }

        .decision-card p {
            color: #a16207;
        }

        .action-card {
            background: var(--primary-gradient);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .btn-authorize {
            background: var(--success-gradient);
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
            transition: all 0.3s ease;
        }

        .btn-authorize:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.45);
            color: #fff;
        }

        .btn-stop {
            background: var(--danger-gradient);
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            color: #fff;
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.35);
            transition: all 0.3s ease;
        }

        .btn-stop:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(239, 68, 68, 0.45);
            color: #fff;
        }

        .btn-create-lote {
            background: rgba(255,255,255,0.95);
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            color: #667eea;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }

        .btn-create-lote:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
            background: #fff;
            color: #764ba2;
        }

        .input-modern {
            background: rgba(255,255,255,0.9);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .input-modern:focus {
            background: #fff;
            border-color: rgba(255,255,255,0.8);
            box-shadow: 0 0 0 4px rgba(255,255,255,0.2);
            outline: none;
        }

        .input-group-modern {
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 0.5rem;
        }

        .system-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
        }

        .system-info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .system-info-item:last-child {
            border-bottom: none;
        }

        .system-info-icon {
            width: 32px;
            height: 32px;
            background: #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.875rem;
        }

        .debug-bar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .debug-bar span {
            color: rgba(255,255,255,0.6);
        }

        .debug-bar strong {
            color: #fbbf24;
        }

        .empty-state {
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #94a3b8;
            font-size: 2rem;
        }

        .pieces-highlight {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            color: #1d4ed8;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container py-5">

        {{-- 🧪 DEBUGGER --}}
        <div class="debug-bar d-flex justify-content-between align-items-center">
            <span class="d-flex align-items-center gap-2">
                <i class="bi bi-bug-fill text-warning"></i> 
                <span class="small">Debug Info</span>
            </span>
            <div class="d-flex gap-4 small">
                <span>👤 Rol: <strong>{{ auth()->user()->rol }}</strong></span>
                <span>📄 Estado: <strong>{{ $papeleta->estado }}</strong></span>
            </div>
        </div>

        {{-- ENCABEZADO PRINCIPAL --}}
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">
                    <i class="bi bi-file-earmark-text me-2 opacity-75"></i>Papeleta #{{ $papeleta->id }}
                </h2>
                <p class="mb-0">Gestión y control de producción</p>
            </div>
            
            {{-- Badge de Estado --}}
            <div>
                @if($papeleta->estado === 'AUTORIZADA')
                    <span class="status-badge authorized">
                        <i class="bi bi-check-circle-fill me-1"></i> AUTORIZADA
                    </span>
                @elseif($papeleta->estado === 'DETENIDA')
                    <span class="status-badge stopped">
                        <i class="bi bi-exclamation-octagon-fill me-1"></i> DETENIDA
                    </span>
                @else
                    <span class="status-badge pending">
                        <i class="bi bi-hourglass-split me-1"></i> {{ $papeleta->estado }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row g-4">
            
            {{-- COLUMNA IZQUIERDA --}}
            <div class="col-lg-8">
                
                {{-- TARJETA DE INFORMACIÓN TÉCNICA --}}
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-2">
                            <i class="bi bi-clipboard-data text-primary"></i>
                        </div>
                        <h5 class="mb-0 fw-bold text-dark">Ficha Técnica</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-card h-100">
                                    <div class="label-text">Cliente</div>
                                    <div class="value-text">{{ $papeleta->cliente }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card h-100">
                                    <div class="label-text">Modelo</div>
                                    <div class="value-text">{{ $papeleta->modelo }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card h-100">
                                    <div class="label-text">Marca</div>
                                    <div class="value-text">{{ $papeleta->marca ?? '—' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card h-100">
                                    <div class="label-text">Talla</div>
                                    <div class="value-text">{{ $papeleta->talla ?? '—' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card h-100">
                                    <div class="label-text">Piezas Totales</div>
                                    <div class="value-text">
                                        <span class="pieces-highlight">{{ $papeleta->piezas_totales }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Sección de Autorización --}}
                            @if($papeleta->estado === 'AUTORIZADA' && $papeleta->autorizadoPor)
                                <div class="col-12 mt-2">
                                    <div class="authorization-banner d-flex align-items-center gap-4">
                                        <div class="icon-wrapper">
                                            <i class="bi bi-patch-check-fill"></i>
                                        </div>
                                        <div>
                                            <div class="text-success fw-bold text-uppercase small mb-1" style="letter-spacing: 1px;">
                                                Autorizado Oficialmente
                                            </div>
                                            <div class="fw-bold text-dark fs-5">
                                                {{ $papeleta->autorizadoPor->nombre_completo ?? $papeleta->autorizadoPor->name }}
                                            </div>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
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
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-info bg-opacity-10 rounded-3 p-2">
                                <i class="bi bi-boxes text-info"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Historial de Lotes</h5>
                        </div>
                        <span class="badge bg-dark rounded-pill px-3 py-2">
                            {{ $papeleta->lotes->count() }} lotes
                        </span>
                    </div>
                    <div class="card-body p-0">
                        @if($papeleta->lotes->count())
                            @foreach($papeleta->lotes as $lote)
                                <div class="lote-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="lote-icon">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">Lote #{{ $lote->id }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-stack me-1"></i>
                                                {{ $lote->cantidad }} piezas registradas
                                            </small>
                                        </div>
                                    </div>
                                    <span class="lote-badge">
                                        {{ $lote->estado ?? 'EN PRODUCCIÓN' }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state text-center">
                                <div class="empty-state-icon">
                                    <i class="bi bi-box2"></i>
                                </div>
                                <h6 class="fw-bold text-secondary mb-2">Sin lotes registrados</h6>
                                <p class="text-muted small mb-0">No se han generado lotes para esta papeleta aún.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- COLUMNA DERECHA --}}
            <div class="col-lg-4">
                
                {{-- ZONA DE DECISIÓN --}}
                @if(auth()->user()->rol === 'Administrador' && $papeleta->estado === 'CREADA')
                    <div class="decision-card mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-warning bg-opacity-25 rounded-3 p-2">
                                <i class="bi bi-shield-exclamation text-warning fs-5"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Requiere Revisión</h5>
                        </div>
                        <p class="small mb-4">Como administrador, debes validar esta papeleta antes de iniciar producción.</p>
                        
                        <div class="d-grid gap-3">
                            <form method="POST" action="{{ route('papeletas.autorizar', $papeleta->id) }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-authorize w-100">
                                    <i class="bi bi-check-lg me-2"></i> Autorizar Papeleta
                                </button>
                            </form>

                            <form method="POST" action="{{ route('papeletas.detener', $papeleta->id) }}">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-stop w-100">
                                    <i class="bi bi-x-lg me-2"></i> Detener Producción
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- 🖥️ BOTÓN NUEVO: INICIAR PRODUCCIÓN (GENERAR LOTES) --}}
                @if(auth()->user()->rol === 'Administrador' || auth()->user()->rol === 'Supervisor')
                    @if($papeleta->estado === 'AUTORIZADA' && $papeleta->lotes->count() === 0)
                        <div class="card mb-4 border-2 border-primary border-opacity-25 bg-light">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3">
                                        <i class="bi bi-rocket-takeoff text-primary fs-3"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark">Inicializar Producción</h5>
                                <p class="text-muted small mb-3">La papeleta está lista. Genera los lotes automáticamente para iniciar.</p>

                                <form method="POST" action="{{ route('papeleta.iniciarProduccion', $papeleta->id) }}">
                                    @csrf
                                    <button class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                        🚀 Iniciar Producción (Generar Lotes)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- ZONA DE ACCIÓN: CREAR LOTE MANUAL --}}
                @if((auth()->user()->rol === 'Administrador General' || auth()->user()->rol === 'Administrador') && $papeleta->estado === 'AUTORIZADA')
                    <div class="action-card mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-white bg-opacity-25 rounded-3 p-2">
                                <i class="bi bi-plus-circle-dotted text-white fs-5"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-0">Nuevo Lote Manual</h5>
                        </div>
                        <p class="small text-white-50 mb-4">Genere un nuevo lote adicional vinculado a esta papeleta.</p>
                        
                        <form method="POST" action="{{ route('lotes.store') }}">
                            @csrf
                            <input type="hidden" name="papeleta_id" value="{{ $papeleta->id }}">

                            <div class="mb-4">
                                <label class="form-label text-white small fw-bold mb-2" style="letter-spacing: 0.5px;">
                                    CANTIDAD A PRODUCIR
                                </label>
                                <div class="input-group-modern d-flex gap-2">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3 d-flex align-items-center">
                                        <i class="bi bi-123 text-white"></i>
                                    </div>
                                    <input type="number" 
                                           name="cantidad" 
                                           class="form-control input-modern flex-grow-1" 
                                           required 
                                           min="1" 
                                           placeholder="Ej. 50">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-create-lote w-100">
                                <i class="bi bi-plus-lg me-2"></i> Crear Lote
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Resumen Informativo --}}
                <div class="card">
                    <div class="card-body system-info p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-info-circle text-secondary"></i>
                            <small class="text-secondary fw-bold text-uppercase" style="letter-spacing: 1px;">
                                Información del sistema
                            </small>
                        </div>
                        
                        <div class="system-info-item">
                            <div class="system-info-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Fecha de creación</small>
                                <span class="fw-semibold text-dark small">{{ $papeleta->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="system-info-item">
                            <div class="system-info-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Cliente asignado</small>
                                <span class="fw-semibold text-dark small">{{ $papeleta->cliente }}</span>
                            </div>
                        </div>
                        
                        <div class="system-info-item">
                            <div class="system-info-icon">
                                <i class="bi bi-flag"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Prioridad</small>
                                <span class="fw-semibold text-dark small">Normal</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>