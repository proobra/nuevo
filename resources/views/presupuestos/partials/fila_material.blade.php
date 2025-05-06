
<form method="POST" action="{{ route('materiales.update', $material->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="replanteo_id" value="{{ $material->replanteo_id }}">
    <div class="card mb-2 ms-3">
        <div class="card-body p-2">
            <div class="row g-2">
                <div class="col"><input type="text" name="descripcion" class="form-control" value="{{ $material->descripcion }}"></div>
                <div class="col"><input type="number" step="0.01" name="cantidad_unidades" class="form-control" value="{{ $material->cantidad_unidades }}"></div>
                <div class="col"><input type="number" step="0.01" name="costo_unitario" class="form-control" value="{{ $material->costo_unitario }}"></div>
                <div class="col"><input type="number" name="manos" class="form-control" value="{{ $material->manos }}"></div>
                <div class="col"><input type="number" step="0.01" name="rendimiento" class="form-control" value="{{ $material->rendimiento }}"></div>
                <div class="col"><input type="number" step="0.01" name="litros_por_lata" class="form-control" value="{{ $material->litros_por_lata }}"></div>
            </div>
        </div>
    </div>
</form>
