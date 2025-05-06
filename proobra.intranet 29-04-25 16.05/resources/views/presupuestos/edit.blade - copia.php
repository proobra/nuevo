@extends('layouts.app')

@section('content')
<div class="container">


{{-- ALERTA DE ÉXITO --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
@endif


  <h2 class="text-center">
    {{--Titulo PPTO--}}
    Presupuesto PPTO{{ $presupuesto->id }}{{ $presupuesto->titulo ? "_{$presupuesto->titulo}" : '' }}{{ $presupuesto->direccion ? "_{$presupuesto->direccion}" : '' }}
  </h2>

  <form class="presupuesto-form" action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">

    @csrf
    @method('PUT')
       
@include('presupuestos.partials.datos_cliente')
@include('presupuestos.partials.datos_obra')


   <!-- BOTONES -->
   <div class="p-3 mb-4" style="background-color: #f2f2f2; border-radius: 8px;">

    <div class="d-flex flex-wrap align-items-center gap-2 justify-content-center">

      <!-- Dropdown Estado del Presupuesto -->
      <div class="btn-group">
        <button type="button" class="btn px-4 py-2 dropdown-toggle"
                style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;"
                data-bs-toggle="dropdown" aria-expanded="false">
          🎯 Estado
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">✅ Aceptado</a></li>
          <li><a class="dropdown-item" href="#">🚀 Iniciar Obra</a></li>
          <li><a class="dropdown-item" href="#">⏸️ Pausar Obra</a></li>
          <li><a class="dropdown-item" href="#">🛑 Finalizar Obra</a></li>
          <li><a class="dropdown-item" href="#">🔍 En Revisión</a></li>
        </ul>
      </div>

      <!-- Dropdown Acciones -->
      <div class="btn-group">
        <button type="button" class="btn px-4 py-2 dropdown-toggle"
                style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;"
                data-bs-toggle="dropdown" aria-expanded="false">
          ⚙️ Acciones
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('presupuestos.crear_hijo', $presupuesto->id) }}">➕ Crear Hijo</a></li>
          <li><a class="dropdown-item" href="#">➕ Crear Hijo Clon</a></li>
          <li><a class="dropdown-item" href="#">📋 Duplicar</a></li>
        </ul>
      </div>

      <!-- Botón Informe Técnico -->
      <a href="{{ route('presupuestos.informe_tecnico', $presupuesto->id) }}" 
         class="btn px-4 py-2"
         style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;">
        📄 Informe Técnico
      </a>

      <!-- Botón Guardar -->
      <button type="submit" class="btn px-4 py-2"
              style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;">
        💾 Guardar
      </button>

      <!-- Botón Volver al Padre (si es hijo) -->
      @if($presupuesto->presupuesto_padre_id)
        <a href="{{ route('presupuestos.edit', $presupuesto->presupuesto_padre_id) }}" 
           class="btn px-4 py-2"
           style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;">
          🔙 Volver al Padre
        </a>
      @endif

      <!-- Botones vacíos para completar espacio -->
      <button type="button" class="btn px-4 py-2" style="background-color: #f2f2f2; border: 1px solid transparent; visibility: hidden;">Espacio</button>
      <button type="button" class="btn px-4 py-2" style="background-color: #f2f2f2; border: 1px solid transparent; visibility: hidden;">Espacio</button>
      <button type="button" class="btn px-4 py-2" style="background-color: #f2f2f2; border: 1px solid transparent; visibility: hidden;">Espacio</button>

    </div>
</div>


@include('presupuestos.partials._replanteo')
@include('presupuestos.partials._materiales')
@include('presupuestos.partials._mano_obra')
@include('presupuestos.partials._gastos', ['gastosFijos' => $gastosFijos, 'presupuesto' => $presupuesto])

<table class="table mt-4">
  <tbody>
            <tr><th>Subtotal Mano de Obra</th><td><span id="subtotal_mo">$ 0.00</span></td></tr>
            <tr><th>Subtotal Materiales</th><td><span id="subtotal_materiales">$ 0.00</span></td></tr>
            <tr><th>Subtotal Gastos Fijos</th><td><span id="subtotal_gastos">$ 0.00</span></td></tr>
            <tr><th>Utilidad</th><td><span id="utilidad_monto">$ 0.00</span></td></tr>
            <tr><th>Subtotal General</th><td><span id="subtotal_general">$ 0.00</span></td></tr>
            <tr><th>IVA (22%)</th><td><span id="iva">$ 0.00</span></td></tr>
            <tr><th>BPS</th><td><span id="bps_monto">$ 0.00</span></td></tr>
            <tr class="table-success fw-bold"><th>Total Final</th><td><span id="total_final">$ 0.00</span></td></tr>
        

      <td colspan="5" class="text-end">Precio por m² (general):</td>
      <td id="precioPorM2">$ 0,00</td>
    </tr>
     <tr>
        <td colspan="5" class="text-end">% Utilidad sobre MO + Materiales:</td>
        <td id="porcentajeUtilidadSobreCostos">0 %</td>
      </tr>
            
    <tr>
      <td colspan="5" class="text-end">% Utilidad sobre mano de obra:</td>
      <td id="porcentajeUtilidad">0 %</td>
    </tr>
  </tbody>
</table>

{{--Boton Guardar Presupuestos--}}
<div class="d-flex justify-content-center mt-4">
  <button type="submit" class="btn btn-light w-100 mt-3">
      💾 Guardar Presupuesto
  </button>
</div>


<input type="hidden" name="subtotal_mano_obra" id="input_subtotal_mano_obra" value="0">
<input type="hidden" name="subtotal_materiales" id="input_subtotal_materiales" value="0">
<input type="hidden" name="subtotal_gastos_fijos" id="input_subtotal_gastos_fijos" value="0">
<input type="hidden" name="utilidad_monto" id="input_utilidad_monto" value="0">
<input type="hidden" name="subtotal_general" id="input_subtotal_general" value="0">
<input type="hidden" name="iva_monto" id="input_iva_monto" value="0">
<input type="hidden" name="bps_monto" id="input_bps_monto" value="0">
<input type="hidden" name="total_final" id="input_total_final" value="0">

</form>

{{-- Línea de separación para evitar colapsos visuales --}}
<hr class="my-5">

{{-- Mostrar presupuestos hijos debajo si es padre --}}
@if($presupuesto->hijos && $presupuesto->hijos->count())
    <h3 class="mt-5">Presupuestos Hijos</h3>

    @foreach($presupuesto->hijos as $hijo)
        <div class="p-3 my-4" style="background-color: #f2f2f2; border: 1px solid #ddd; border-radius: 8px;">
            <h4 class="mb-3">Presupuesto Hijo: PPTO{{ $hijo->id }} {{ $hijo->titulo }}</h4>

            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Dirección:</strong> {{ $hijo->direccion ?? 'Sin dirección' }}
                </div>
                <div class="col-md-6">
                    <strong>Cliente:</strong> {{ $hijo->cliente ?? 'Sin cliente' }}
                </div>
            </div>

            <div class="d-flex justify-content-start gap-2">
                <a href="{{ route('presupuestos.edit', $hijo->id) }}" class="btn btn-primary btn-sm">
                    ✏️ Editar Hijo
                </a>
                {{-- Otros botones que quieras agregar después --}}
            </div>
        </div>
    @endforeach
@endif



</div>
{{-- Scripts JS --}}
@push('scripts')
@include('presupuestos.partials._scripts') {{-- o el nombre correcto del archivo que tenga la función agregarFilaReplanteo --}}
@endpush
