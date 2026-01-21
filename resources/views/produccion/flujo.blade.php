<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Flujo de Producción | GALGA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <h2 class="fw-bold mb-4">Flujo de Producción</h2>

    @if($lotes->isEmpty())
        <div class="alert alert-info">
            No hay lotes en producción.
        </div>
    @else

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Lote</th>
                    <th>Papeleta</th>
                    <th>Área Actual</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lotes as $lote)
                    <tr>
                        <td>#{{ $lote->id }}</td>
                        <td>{{ $lote->papeleta->folio ?? '—' }}</td>
                        <td>{{ $lote->area_actual ?? 'Pendiente' }}</td>
                        <td>
                            <span class="badge bg-success">
                                EN PRODUCCIÓN
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</div>

</body>
</html>
