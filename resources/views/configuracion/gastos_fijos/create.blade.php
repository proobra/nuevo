@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agregar Gasto Fijo</h2>

    <form action="{{ route('configuracion.gastos-fijos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" class="form-control" name="valor" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" name="tipo" required>
                <option value="monto">Monto fijo</option>
                <option value="porcentaje">Porcentaje</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="editable" value="1" checked>
            <label class="form-check-label">Editable</label>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('configuracion.gastos-fijos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
