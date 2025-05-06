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

</div> {{-- 🔵 Cierre del marco --}}

{{-- ✅ Presupuestos hijos si existen --}}
@if($presupuesto->hijos && $presupuesto->hijos->count())
    <h3 class="mt-5">Presupuestos Hijos</h3>

    @foreach($presupuesto->hijos as $hijo)
        @include('presupuestos.partials._hijo', ['hijo' => $hijo])
    @endforeach
@endif


</div>
@endsection

@push('scripts')
  @include('presupuestos.partials._scripts')
@endpush
