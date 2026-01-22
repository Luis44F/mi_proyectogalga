<h3 class="mb-3">📄 Papeleta #{{ $papeleta->id }}</h3>
<p>Estado: <strong>{{ $papeleta->estado }}</strong></p>

---

{{-- SECCIÓN: AUTORIZACIÓN (Solo si está Pendiente) --}}
@if(auth()->user()->rol === 'Administrador General' && $papeleta->estado === 'Pendiente')
    <form method="POST" action="{{ route('papeletas.autorizar', $papeleta) }}">
        @csrf
        @method('PUT')

        <button class="btn btn-warning mb-3">
            ✅ Autorizar y enviar a producción
        </button>
    </form>
@endif

{{-- SECCIÓN: CREAR LOTE (Solo si está Autorizada) --}}
@if(auth()->user()->rol === 'Administrador General' && $papeleta->estado === 'AUTORIZADA')
    <div class="card card-body mb-4">
        <h5>Crear nuevo lote</h5>
        <form method="POST" action="{{ route('lotes.store') }}">
            @csrf
            <input type="hidden" name="papeleta_id" value="{{ $papeleta->id }}">

            <div class="mb-2">
                <label class="form-label">Cantidad del lote</label>
                <input type="number" name="cantidad" class="form-control" required>
            </div>

            <button class="btn btn-success">
                ➕ Crear lote
            </button>
        </form>
    </div>
@endif

<hr>

<h5>Lotes creados</h5>
<ul class="list-group">
    @forelse($papeleta->lotes as $lote)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Lote: <strong>{{ $lote->numero_lote }}</strong></span>
            <span class="badge bg-info text-dark">{{ $lote->area_actual }}</span>
        </li>
    @empty
        <li class="list-group-item text-muted">No hay lotes creados para esta papeleta.</li>
    @endforelse
</ul>