@extends('layouts.app')

@section('content')
    <h1>Panel de Control PROOBRA</h1>
    <p>Bienvenido, {{ Auth::user()->name }}.</p>

    <hr>

    <h3>Obras en ejecución</h3>
    @forelse ($obrasEnEjecucion as $obra)
        <div class="card mb-2 p-2">
            <strong>{{ $obra->nombre }}</strong><br>
            Inicio: {{ \Carbon\Carbon::parse($obra->fecha_inicio)->format('d/m/Y') }}<br>
            Duración: {{ $obra->duracion_dias }} días<br>
            Días transcurridos: {{ $obra->dias_transcurridos }}<br>
            Días restantes: {{ $obra->dias_restantes }}<br>
            Estado: {{ $obra->estado_avance }}
        </div>
    @empty
        <p>No hay obras en ejecución.</p>
    @endforelse

    <h3 class="mt-4">Obras aceptadas en espera</h3>
    @forelse ($obrasAceptadas as $obra)
        <div class="card mb-2 p-2">
            <strong>{{ $obra->nombre }}</strong><br>
            Fecha estimada de inicio: {{ $obra->fecha_aceptacion }}
        </div>
    @empty
        <p>No hay obras aceptadas en espera de inicio.</p>
    @endforelse

    <h3 class="mt-4">Alertas</h3>
    <ul>
        @forelse ($alertas as $alerta)
            <li>⚠️ {{ $alerta }}</li>
        @empty
            <li>No hay alertas por el momento.</li>
        @endforelse
    </ul>
@endsection
