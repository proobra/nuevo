<div class="card p-3 mb-4">
    <h5 class="mb-3">Datos de la obra</h5>

    <div class="row g-3">
    <div class="col-md-6">
    <label for="titulo" class="form-label">Título del presupuesto (uso interno)</label>
    <input type="text" id="titulo" name="titulo" class="form-control"
           value="{{ old('titulo', $presupuesto->titulo ?? 'nuevo presupuesto') }}" required>
</div>

<div class="col-md-6">
    <label for="titulo_caratula" class="form-label">Título de carátula (PDF)</label>
    <input type="text" id="titulo_caratula" name="titulo_caratula" class="form-control"
           value="{{ old('titulo_caratula', $presupuesto->titulo_caratula ?? '') }}">
</div>

        <div class="col-md-4">
            <label for="fecha" class="form-label">Fecha de inicio de elaboración</label>
            <input type="date" id="fecha" name="fecha" class="form-control"
                   value="{{ old('fecha', isset($presupuesto->fecha) ? \Carbon\Carbon::parse($presupuesto->fecha)->format('Y-m-d') : '') }}">
            <small class="form-text text-muted">
                Esta fecha corresponde al inicio de la elaboración del presupuesto, no a la ejecución de la obra.
            </small>
        </div>
        

        <div class="col-md-4">
            <label for="superficie" class="form-label">Superficie total (m²)</label>
            <input type="number" name="superficie" id="superficie" class="form-control"
            value="{{ old('superficie', $presupuesto->superficie ?? '') }}">
     
        </div>


        <div class="col-md-4">
    <label for="utilidad_input" class="form-label">Utilidad (%)</label>
    <input type="number" step="0.01" id="utilidad_input" name="utilidad" class="form-control"
           value="{{ old('utilidad', $presupuesto->utilidad ?? 0) }}">
</div>


        <div class="col-md-12">
            <label for="comentarios" class="form-label">Comentarios adicionales</label>
            <textarea id="comentarios" name="comentarios" class="form-control" rows="3">{{ old('comentarios', $presupuesto->comentarios ?? '') }}</textarea>
        </div>
    </div>
</div>