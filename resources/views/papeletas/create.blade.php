<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Papeleta | GALGA</title>
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { background-color: #f0f2f5; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .card-header { background: #fff; border-bottom: 1px solid #eee; border-radius: 15px 15px 0 0 !important; padding: 1.5rem; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #555; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15); border-color: #0d6efd; }
        .btn { border-radius: 8px; padding: 10px 20px; font-weight: 500; }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10"> {{-- Limita el ancho en pantallas muy grandes --}}
            
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-file-earmark-plus text-primary me-2"></i>Nueva Papeleta
                        </h4>
                        <small class="text-muted">Complete la información para iniciar la producción</small>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('papeletas.store') }}">
                        @csrf

                        {{-- SECCIÓN 1: INFORMACIÓN PRINCIPAL --}}
                        <h6 class="text-primary fw-bold mb-3"><i class="bi bi-info-circle me-1"></i> Datos Principales</h6>
                        <div class="row g-3 mb-4">
                            {{-- Cliente --}}
                            <div class="col-md-6">
                                <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente" required>
                                </div>
                            </div>

                            {{-- Modelo --}}
                            <div class="col-md-6">
                                <label class="form-label">Modelo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                    <input type="text" name="modelo" class="form-control" placeholder="Ej. Pantalón Slim" required>
                                </div>
                            </div>
                        </div>

                        {{-- SECCIÓN 2: DETALLES TÉCNICOS --}}
                        <h6 class="text-primary fw-bold mb-3 mt-4"><i class="bi bi-sliders me-1"></i> Especificaciones</h6>
                        <div class="row g-3 mb-4">
                            
                            {{-- Piezas Totales (Destacado) --}}
                            <div class="col-md-4">
                                <label class="form-label">Piezas Totales <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-123"></i></span>
                                    <input type="number" name="piezas_totales" class="form-control" min="1" placeholder="0" required>
                                </div>
                            </div>

                            {{-- Talla --}}
                            <div class="col-md-4">
                                <label class="form-label">Talla <span class="text-danger">*</span></label>
                                <input type="text" name="talla" class="form-control" placeholder="Ej. M, 32, G" required>
                            </div>

                            {{-- Marca --}}
                            <div class="col-md-4">
                                <label class="form-label">Marca</label>
                                <input type="text" name="marca" class="form-control" placeholder="Marca del producto">
                            </div>

                            {{-- Color --}}
                            <div class="col-md-6">
                                <label class="form-label">Color</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-palette"></i></span>
                                    <input type="text" name="color" class="form-control" placeholder="Ej. Azul Marino">
                                </div>
                            </div>

                            {{-- Material --}}
                            <div class="col-md-6">
                                <label class="form-label">Material / Tela</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-box-seam"></i></span>
                                    <input type="text" name="material" class="form-control" placeholder="Ej. Mezclilla 14oz">
                                </div>
                            </div>
                        </div>

                        {{-- SECCIÓN 3: EXTRAS --}}
                        <div class="mb-4">
                            <label class="form-label">Observaciones Adicionales</label>
                            <textarea name="observaciones" class="form-control" rows="3" placeholder="Detalles especiales sobre costuras, entregas, etc."></textarea>
                        </div>

                        <hr class="my-4">

                        {{-- BOTONES DE ACCIÓN --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-light text-secondary border">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Guardar Papeleta
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>