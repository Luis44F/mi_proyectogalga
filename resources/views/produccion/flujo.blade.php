<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Flujo de Producción | GALGA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', system-ui, sans-serif; }
        
        .main-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            background: white;
            overflow: hidden;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.5rem;
        }

        .table { margin-bottom: 0; }
        .table thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            border-bottom: 2px solid #e9ecef;
            padding: 1rem;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #495057;
            font-size: 0.95rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-hover tbody tr:hover {
            background-color: #fcfcfc;
        }

        .lote-id {
            font-weight: 700;
            color: #0d6efd;
            background: #e7f1ff;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .papeleta-ref {
            font-weight: 600;
            color: #212529;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-prod { background-color: #d1e7dd; color: #0f5132; }
        
        .empty-state { padding: 4rem 2rem; text-align: center; }
        .empty-icon { font-size: 3rem; color: #dee2e6; margin-bottom: 1rem; }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">🏭 Flujo de Producción</h2>
            <p class="text-muted mb-0">Monitoreo de lotes en tiempo real</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="main-card">
        
        @if($lotes->isEmpty())
            <div class="empty-state">
                <i class="bi bi-box-seam empty-icon"></i>
                <h5 class="fw-bold text-muted">No hay producción activa</h5>
                <p class="text-secondary small">Los lotes creados aparecerán en esta lista.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4">Lote ID</th>
                            <th scope="col">Ref. Papeleta</th>
                            <th scope="col">Área Actual</th>
                            <th scope="col">Avance</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-center pe-4">Acción</th> {{-- Nueva Columna --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lotes as $lote)
                            <tr>
                                <td class="ps-4">
                                    <span class="lote-id">
                                        <i class="bi bi-box-seam me-1"></i> #{{ $lote->id }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="papeleta-ref">
                                            {{ $lote->papeleta->cliente ?? 'Cliente Genérico' }}
                                        </span>
                                        <small class="text-muted" style="font-size: 0.8rem;">
                                            Folio: {{ $lote->papeleta->id ?? '—' }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-secondary fw-medium">
                                        <i class="bi bi-geo-alt me-2 text-primary"></i>
                                        {{ $lote->area_actual ?? 'Pendiente' }}
                                    </div>
                                </td>
                                <td>
                                    {{-- Barra de progreso visual real usando el helper del modelo --}}
                                    <div class="progress" style="height: 6px; width: 100px; background-color: #e9ecef;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $lote->progreso }}%"></div>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $lote->progreso }}%</small>
                                </td>
                                <td>
                                    <span class="status-badge badge-prod">
                                        <span class="spinner-grow spinner-grow-sm me-1" style="width: 8px; height: 8px;"></span>
                                        EN PRODUCCIÓN
                                    </span>
                                </td>
                                {{-- Botón de Acción --}}
                                <td class="text-center pe-4">
                                    <a href="{{ url('produccion/'.$lote->id.'/validar') }}" 
                                       class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-check-circle me-1"></i> Validar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="bg-light p-3 border-top d-flex justify-content-end">
                <small class="text-muted fw-bold">Total Lotes: {{ $lotes->count() }}</small>
            </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>