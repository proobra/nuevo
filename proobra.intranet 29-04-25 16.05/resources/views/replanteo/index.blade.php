@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Replanteo de Tareas</h2>

    <a href="{{ route('replanteo.create', $presupuesto->id) }}" class="btn btn-success mb-3">
        Agregar nueva tarea
    </a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Orden</th>
                <th>Descripción</th>
                <th>Días</th>
                <th>m²</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($replanteos as $tarea)
            <tr>
                <td>{{ $tarea->id }}</td>
                <td>{{ $tarea->orden }}</td>
                <td>{{ $tarea->descripcion_tarea }}</td>
                <td>{{ $tarea->dias }}</td>
                <td>{{ $tarea->metros2 }}</td>
                <td>{{ $tarea->observaciones }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
