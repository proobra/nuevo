@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="text-center">Crear nuevo presupuesto</h2>

  <form class="presupuesto-form" action="{{ route('presupuestos.store') }}" method="POST">
    @csrf

    @include('presupuestos.partials.datos_cliente')
    @include('presupuestos.partials.datos_obra')
    @include('presupuestos.partials._replanteo')
    @include('presupuestos.partials._mano_obra')
    @include('presupuestos.partials._materiales')
    @include('presupuestos.partials._gastos', ['gastosFijos' => $gastosFijos, 'presupuesto' => null])

    {{-- Resumen final --}}
    <table class="table mt-4">
      <!-- ... (resumen como en edit.blade.php) -->
    </table>

    <div class="text-end mt-4">
      <button class="btn btn-success" type="submit">Crear presupuesto</button>
    </div>
  </form>
</div>

@push('scripts')
  @include('presupuestos.partials._scripts')
@endpush
@endsection
