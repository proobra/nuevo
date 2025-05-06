@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">💼 Laudos de Operarios</h2>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORMULARIO PARA AGREGAR NUEVO LAUDO --}}
    <form action="{{ route('laudos.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-2"><input type="number" name="orden" class="form-control" placeholder="Orden" required></div>
        <div class="col-md-2"><input type="text" name="categoria" class="form-control" placeholder="Categoría" required></div>
        <div class="col-md-2"><input type="text" name="sector" class="form-control" placeholder="Sector"></div>
        <div class="col-md-2"><input type="number" step="0.01" name="laudo_base" class="form-control" placeholder="Laudo base" required></div>
        <div class="col-md-2"><input type="number" step="0.01" name="desgaste_ropa" class="form-control" placeholder="Ropa"></div>
        <div class="col-md-2"><input type="number" step="0.01" name="transporte" class="form-control" placeholder="Transporte"></div>
        <div class="col-md-2 mt-2"><input type="number" step="0.01" name="s_balancin" class="form-control" placeholder="Balancín"></div>
        <div class="col-md-2 mt-2"><input type="number" step="0.01" name="herramientas" class="form-control" placeholder="Herramientas"></div>
        <div class="col-md-2 mt-2"><input type="number" step="0.01" name="alimentos" class="form-control" placeholder="Alimentos"></div>
        <div class="col-md-2 mt-2"><input type="number" step="0.01" name="presentismo_semanal" class="form-control" placeholder="Pres. Sem."></div>
        <div class="col-md-2 mt-2"><input type="number" step="0.01" name="presentismo_mensual" class="form-control" placeholder="Pres. Men."></div>
        <div class="col-md-2 mt-2">
            <button type="submit" class="btn btn-success w-100">+ Agregar</button>
        </div>
    </form>

    {{-- TABLA DE LAUDOS EXISTENTES --}}
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>Orden</th>
                <th>Categoría</th>
                <th>Sector</th>
                <th>Laudo Base</th>
                <th>Ropa</th>
                <th>Transp.</th>
                <th>Balancín</th>
                <th>Herram.</th>
                <th>Alimentos</th>
                <th>Pres. Sem.</th>
                <th>Pres. Men.</th>
                <th>Total Jornal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laudos as $laudo)
            <tr>
                <form action="{{ route('laudos.update', $laudo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td><input type="number" name="orden" value="{{ $laudo->orden }}" class="form-control" style="width: 80px;"></td>
                    <td><input type="text" name="categoria" value="{{ $laudo->categoria }}" class="form-control"></td>
                    <td><input type="text" name="sector" value="{{ $laudo->sector }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="laudo_base" value="{{ $laudo->laudo_base }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="desgaste_ropa" value="{{ $laudo->desgaste_ropa }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="transporte" value="{{ $laudo->transporte }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="s_balancin" value="{{ $laudo->s_balancin }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="herramientas" value="{{ $laudo->herramientas }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="alimentos" value="{{ $laudo->alimentos }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="presentismo_semanal" value="{{ $laudo->presentismo_semanal }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="presentismo_mensual" value="{{ $laudo->presentismo_mensual }}" class="form-control"></td>
                    <td class="text-center">
                        ${{ number_format(
                            $laudo->laudo_base +
                            $laudo->desgaste_ropa +
                            $laudo->transporte +
                            $laudo->s_balancin +
                            $laudo->herramientas +
                            $laudo->alimentos +
                            $laudo->presentismo_semanal +
                            $laudo->presentismo_mensual, 2) }}
                    </td>
                    <td class="text-center d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-primary">💾</button>
                </form>
                <form action="{{ route('laudos.destroy', $laudo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este laudo?')">🗑️</button>
                </form>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
