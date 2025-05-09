@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard de Proobra</h1>
    
    <div class="card mb-3">
        <div class="card-body">
            <p>📋 Bienvenido al panel de gestión de presupuestos.</p>
            <p>Desde aquí podrás crear nuevos presupuestos o acceder a los existentes.</p>
        </div>
    </div>

    <a href="{{ route('presupuestos.create') }}" class="btn btn-primary">
        ➕ Crear nuevo presupuesto
    </a>
</div>
@endsection

