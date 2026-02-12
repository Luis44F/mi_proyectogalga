<form action="{{ route('flujo.validar', $flujo->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="file" name="foto" required>

    <textarea name="observaciones"
              placeholder="Observaciones opcionales"></textarea>

    <button type="submit">
        Validar {{ $flujo->fase }}
    </button>
</form>
