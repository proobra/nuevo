@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 bg-white shadow rounded">
    <h1 class="text-xl font-bold mb-4">Presupuesto #{{ $presupuesto->id }}</h1>
    <p><strong>Cliente:</strong> {{ $presupuesto->cliente }}</p>
    <p><strong>Empresa:</strong> {{ $presupuesto->empresa }}</p>
    <p><strong>Teléfono:</strong> {{ $presupuesto->telefono }}</p>
    <p><strong>Email:</strong> {{ $presupuesto->email }}</p>
</div>
@endsection
