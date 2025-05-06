@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="text-center">
    Presupuesto PPTO{{ $presupuesto->id }}{{ $presupuesto->titulo ? "_{$presupuesto->titulo}" : '' }}{{ $presupuesto->direccion ? "_{$presupuesto->direccion}" : '' }}
  </h2>

  <form action="{{ route('presupuestos.update', $presupuesto->id) }}" method="POST">
    @csrf
    @method('PUT')

    @include('partials._replanteo')
    @include('partials._mano_obra')
    @include('partials._materiales')
    @include('partials._gastos')

    <div class="text-end mt-4">
      <button class="btn btn-success" type="submit">Guardar presupuesto</button>
    </div>
  </form>
</div>

@include('partials._scripts')
@endsection
