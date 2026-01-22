<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Papeleta | GALGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            ➕ Crear nueva papeleta
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('papeletas.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" name="cliente" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Modelo</label>
                    <input type="text" name="modelo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Talla</label>
                    <input type="text" name="talla" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Piezas Totales</label>
                    <input type="number" name="piezas_totales" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Marca</label>
                    <input type="text" name="marca" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Material</label>
                    <input type="text" name="material" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        ⬅ Volver
                    </a>

                    <button class="btn btn-success">
                        💾 Guardar papeleta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
