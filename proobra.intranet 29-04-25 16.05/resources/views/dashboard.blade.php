
<h2>Obras en ejecución</h2>
@foreach ($obrasEnEjecucion as $obra)
    <div class="card">
        <strong>{{ $obra->nombre }}</strong><br>
        Inicio: {{ \Carbon\Carbon::parse($obra->fecha_inicio)->format('d/m/Y') }}<br>
        Duración: {{ $obra->duracion_dias }} días<br>
        Días transcurridos: {{ $obra->dias_transcurridos }}<br>
        Días restantes: {{ $obra->dias_restantes }}<br>
        Estado: {{ $obra->estado_avance }}
    </div>
@endforeach

<h2>Obras aceptadas</h2>
@foreach ($obrasAceptadas as $obra)
    <div class="card">
        <strong>{{ $obra->nombre }}</strong><br>
        Fecha estimada de inicio: {{ $obra->fecha_aceptacion }}
    </div>
@endforeach

<h2>Alertas</h2>
<ul>
@foreach ($alertas as $alerta)
    <li>⚠️ {{ $alerta }}</li>
@endforeach
</ul>
