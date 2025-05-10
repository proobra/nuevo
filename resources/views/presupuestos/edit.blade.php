@extends('layouts.app')

@section('content')
<div class="container">

  {{-- ✅ Mensaje de éxito --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  @endif

  {{-- ✅ Título principal --}}
  <h2 class="text-center mb-4">
    Presupuesto PPTO{{ $presupuesto->id }}{{ $presupuesto->titulo ? "_{$presupuesto->titulo}" : '' }}{{ $presupuesto->direccion ? "_{$presupuesto->direccion}" : '' }}
  </h2>

  {{-- ✅ Formulario principal del Padre --}}
  <div class="card p-4 shadow-sm rounded-3 mb-5"> {{-- 🔵 Nuevo marco visual para el Presupuesto Padre --}}

    <form class="presupuesto-form" action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ✅ Secciones principales --}}
        @include('presupuestos.partials.datos_cliente')
        @include('presupuestos.partials.datos_obra')

        {{-- ✅ Barra de botones --}}
        @include('presupuestos.partials._botones_superiores')

        {{-- ✅ Tablas principales --}}
        @include('presupuestos.partials._replanteo')
        @include('presupuestos.partials._materiales')
        @include('presupuestos.partials._mano_obra')
        @include('presupuestos.partials._gastos', ['gastosFijos' => $gastosFijos])

        {{-- ✅ Resumen de Totales --}}
        @include('presupuestos.partials._resumen_totales')


        {{-- ✅ Inputs ocultos de totales --}}
        @include('presupuestos.partials._inputs_ocultos_totales')




        {{-- ✅ Botón final de guardado --}}
        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-light w-100 mt-3">
                💾 Guardar Presupuesto
            </button>
        </div>


    </form>

    {{-- ✅ Presupuestos hijos si existen --}}
    @if($presupuesto->hijos && $presupuesto->hijos->count())
        <h3 class="mt-5">Presupuestos Hijos</h3>
        @php
        $utilidadSobreCostos = [];
        $utilidadSobreManoObra = [];
        @endphp

        @foreach($presupuesto->hijos as $index=> $hijo)
            @include('presupuestos.partials._hijo', ['hijo' => $hijo])
            @php
                @$totalFinalHijos += $hijo->total_final ?? 0;
                @$iva += $hijo->iva_monto ?? 0;
                @$bps += $hijo->bps_monto ?? 0;
                @$utilidad += $hijo->utilidad_monto ?? 0;
                @$subtotalGeneral += $hijo->subtotal_general ?? 0;
                @$subtotalMateriales += $hijo->subtotal_materiales ?? 0;
                @$subtotalGastos += $hijo->subtotal_gastos_fijos ?? 0;
                @$subtotalManoObra += $hijo->subtotal_mano_obra ?? 0;
                $utilidadSobreCostos[] = $hijo->porcentaje_utilidad_sobre_costos ?? 0;
                $utilidadSobreManoObra[] = $hijo->porcentaje_utilidad ?? 0;
                @$precioPorM2 += $hijo->precio_por_m2 ?? 0;
            @endphp
        @endforeach

        @php
        $totalFinal = ($presupuesto->total_final ?? 0) + @$totalFinalHijos;
        $iva = ($presupuesto->iva_monto ?? 0) + @$iva;
        $bps = ($presupuesto->bps_monto ?? 0) + @$bps;
        $utilidad = ($presupuesto->utilidad_monto ?? 0) + @$utilidad;
        $subtotalGeneral = ($presupuesto->subtotal_general ?? 0) + @$subtotalGeneral;
        $subtotalMateriales = ($presupuesto->subtotal_materiales ?? 0) + @$subtotalMateriales;
        $subtotalGastos = ($presupuesto->subtotal_gastos_fijos ?? 0) + @$subtotalGastos;
        $subtotalManoObra = ($presupuesto->subtotal_mano_obra ?? 0) + @$subtotalManoObra;
        //$utilidadSobreCostos = ($presupuesto->porcentaje_utilidad_sobre_costos ?? 0) + @$utilidadSobreCostos;
        //$utilidadSobreManoObra = ($presupuesto->porcentaje_utilidad ?? 0) + @$utilidadSobreManoObra;
        $precioPorM2 = ($presupuesto->precio_por_m2 ?? 0) + @$precioPorM2;
        $presupuestoResumenFinal = (object)[
            'total_final' => $totalFinal ,
            'iva_monto' => $iva,
            'bps_monto' => $bps,
            'utilidad_monto' => $utilidad,
            'subtotal_general' => $subtotalGeneral,
            'subtotal_materiales' => $subtotalMateriales,
            'subtotal_gastos_fijos' => $subtotalGastos,
            'subtotal_mano_obra' => $subtotalManoObra,
            'precio_por_m2' => $precioPorM2,
            'porcentaje_utilidad_sobre_costos' => $utilidadSobreCostos,
            'porcentaje_utilidad' => $utilidadSobreManoObra
        ];
        @endphp
        @include('presupuestos.partials._resumen_totales', ['titulo'=>'Resumen total','presupuesto' => $presupuestoResumenFinal,'utilidadPorPresupuestoHijo'=>true])
    @endif

</div> {{-- 🔵 Cierre del marco --}}
</div>

@endsection

@push('scripts')
  @include('presupuestos.partials._scripts')
@endpush
