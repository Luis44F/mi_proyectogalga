<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lotes | GALGA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

<h3 class="mb-3">
    📄 Papeleta #{{ $papeleta->id }} — {{ $papeleta->modelo }}
</h3>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Lote</th>
            <th>Área</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lotes as $lote)
        <tr>
            <td>{{ $lote->id }}</td>
            <td>{{ $lote->nombre ?? 'Lote '.$lote->id }}</td>
            <td>{{ ucfirst($lote->area) }}</td>
            <td>
                @if($lote->estado === 'pendiente')
                    <span class="badge bg-secondary">Pendiente</span>
                @elseif($lote->estado === 'proceso')
                    <span class="badge bg-warning">En proceso</span>
                @else
                    <span class="badge bg-success">Terminado</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('papeletas.index') }}" class="btn btn-secondary">
    ⬅ Volver a papeletas
</a>

</body>
</html>
