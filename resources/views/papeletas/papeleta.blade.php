<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Papeleta #{{ $papeleta->id }}</title>
    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        
        {{-- 1️⃣ NUEVO ENCABEZADO Y ESTADO --}}
        <h3 class="mb-3">📄 Papeleta #{{ $papeleta->id }}</h3>

        <p class="fs-5">
            Estado:
            <strong class="
                @if($papeleta->estado === 'CREADA') text-secondary
                @elseif($papeleta->estado === 'AUTORIZADA') text-success
                @elseif($papeleta->estado === 'DETENIDA') text-danger
                @endif
            ">
                {{ $papeleta->estado }}
            </strong>
        </p>

        {{-- 🧾 MOSTRAR QUIÉN AUTORIZÓ (solo si aplica) --}}
        @if($papeleta->estado === 'AUTORIZADA' && $papeleta->autorizadoPor)
            <div class="alert alert-success shadow-sm">
                <strong>🧾 Autorizada por:</strong>
                {{ $papeleta->autorizadoPor?->nombre_completo ?? 'No disponible' }}

                <strong>📅 Fecha de autorización:</strong>
                {{-- Asegúrate de que 'fecha_autorizacion' sea tipo 'datetime' en tu modelo --}}
                {{ $papeleta->fecha_autorizacion ? $papeleta->fecha_autorizacion->format('d/m/Y H:i') : 'Fecha no registrada' }}
            </div>
        @endif

        {{-- 2️⃣ FICHA TÉCNICA (INFORMACIÓN) --}}
        <div class="card mb-4 shadow-sm mt-4">
            <div class="card-header bg-white fw-bold">
                📋 Información de la papeleta
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block small">Cliente</strong>
                        {{ $papeleta->cliente }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block small">Modelo</strong>
                        {{ $papeleta->modelo }}
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong class="text-muted d-block small">Talla</strong>
                        {{ $papeleta->talla ?? '—' }}
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong class="text-muted d-block small">Marca</strong>
                        {{ $papeleta->marca ?? '—' }}
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong class="text-muted d-block small">Color</strong>
                        {{ $papeleta->color ?? '—' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block small">Material</strong>
                        {{ $papeleta->material ?? '—' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong class="text-muted d-block small">Piezas totales</strong>
                        {{ $papeleta->piezas_totales }}
                    </div>
                    <div class="col-12 mt-2">
                        <strong class="text-muted d-block small">Observaciones</strong>
                        <span class="text-muted fst-italic">
                            {{ $papeleta->observaciones ?? 'Sin observaciones registradas.' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3️⃣ ZONA DE ACCIONES --}}
        
        {{-- CASO A: Papeleta recién creada -> Requiere autorización --}}
        @if(auth()->user()->rol === 'Administrador' && $papeleta->estado === 'CREADA')
            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-4">
                <span>⚠️ Esta papeleta requiere revisión antes de procesar lotes.</span>
                
                <div class="d-flex gap-2">
                    {{-- Botón AUTORIZAR --}}
                    <form method="POST" action="{{ route('papeletas.autorizar', $papeleta) }}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success fw-bold">
                            ✅ Autorizar
                        </button>
                    </form>

                    {{-- Botón DETENER --}}
                    <form method="POST" action="{{ route('papeletas.detener', $papeleta) }}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-danger fw-bold">
                            ⛔ Detener
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- CASO B: Papeleta Autorizada -> Permite crear lotes --}}
        @if(auth()->user()->rol === 'Administrador' && $papeleta->estado === 'AUTORIZADA')
            <div class="card border-success mb-4">
                <div class="card-header bg-success text-white">
                    ➕ Gestión de Producción
                </div>
                <div class="card-body">
                    <h5>Crear nuevo lote</h5>
                    <p class="text-muted small">Ingrese la cantidad de piezas para generar un nuevo lote asociado a esta papeleta.</p>
                    
                    <form method="POST" action="{{ route('lotes.store') }}" class="row g-3 align-items-end">
                        @csrf
                        <input type="hidden" name="papeleta_id" value="{{ $papeleta->id }}">

                        <div class="col-md-4">
                            <label class="form-label">Cantidad del lote</label>
                            <input type="number" name="cantidad" class="form-control" placeholder="Ej. 50" required min="1">
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary w-100">
                                💾 Crear Lote
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- CASO C: Papeleta Detenida --}}
        @if($papeleta->estado === 'DETENIDA')
            <div class="alert alert-danger text-center shadow-sm">
                ⛔ <strong>Papeleta Detenida:</strong> No se pueden generar lotes hasta que sea reactivada por administración.
            </div>
        @endif

        {{-- 4️⃣ LISTADO DE LOTES --}}
        <hr class="my-5">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>📦 Lotes creados</h5>
            <span class="badge bg-secondary">{{ $papeleta->lotes->count() }} lotes</span>
        </div>

        <ul class="list-group shadow-sm">
            @forelse($papeleta->lotes as $lote)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-bold">Lote #{{ $lote->numero_lote }}</span>
                        <br>
                        <small class="text-muted">Cantidad: {{ $lote->cantidad }} pzs</small>
                    </div>
                    <span class="badge bg-info text-dark border">
                        📍 {{ $lote->area_actual ?? 'En espera' }}
                    </span>
                </li>
            @empty
                <li class="list-group-item text-center text-muted py-3">
                    📭 No hay lotes creados para esta papeleta aún.
                </li>
            @endforelse
        </ul>

    </div>

    {{-- Script Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
