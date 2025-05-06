@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📋 Listado de Presupuestos</h2>

    @if($presupuestos->isEmpty())
        <div class="alert alert-warning">
            No se encontraron presupuestos.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Empresa</th>
                        <th>Título</th>
                        <th>Cliente</th>
                        <th>Dirección</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presupuestos as $presupuesto)
                        <tr>
                            <td>{{ $presupuesto->id }}</td>
                            <td>{{ $presupuesto->empresa }}</td>
                            <td>{{ $presupuesto->titulo }}</td>
                            <td>{{ $presupuesto->cliente }}</td>
                            <td>{{ $presupuesto->direccion }}</td>
                            <td>{{ \Carbon\Carbon::parse($presupuesto->fecha)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('presupuestos.edit', $presupuesto->id) }}" class="btn btn-sm btn-primary">
                                    ✏️ Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
