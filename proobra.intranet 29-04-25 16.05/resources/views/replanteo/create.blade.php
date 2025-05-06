@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agregar tarea al replanteo</h2>

    <form action="{{ route('replanteo.store', $presupuesto->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Descripción de la tarea</label>
            <input type="text" class="form-control" name="descripcion_tarea" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Orden</label>
            <input type="number" class="form-control" name="orden" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Días</label>
            <input type="number" class="form-control" name="dias">
        </div>
        <div class="mb-3">
            <label class="form-label">m²</label>
            <input type="number" step="0.01" class="form-control" name="metros2">
        </div>
        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea class="form-control" name="observaciones"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar tarea</button>
    </form>

    <a href="{{ route('replanteo.index', $presupuesto->id) }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
@endsection
