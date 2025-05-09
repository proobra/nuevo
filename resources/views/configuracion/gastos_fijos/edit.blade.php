@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Gasto Fijo</h2>

    <form action="{{ route('configuracion.gastos-fijos.update', $gasto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="{{ $gasto->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" step="0.01" class="form-control" name="valor" value="{{ $gasto->valor }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" name="tipo" required>
                <option value="monto" {{ $gasto->tipo === 'monto' ? 'selected' : '' }}>Monto fijo</option>
                <option value="porcentaje" {{ $gasto->tipo === 'porcentaje' ? 'selected' : '' }}>Porcentaje</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="editable" value="1" {{ $gasto->editable ? 'checked' : '' }}>
            <label class="form-check-label">Editable</label>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('configuracion.gastos-fijos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
