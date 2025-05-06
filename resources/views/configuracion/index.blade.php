@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Configuración General</h2>

    <ul class="nav nav-tabs" id="configTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="gastos-tab" data-bs-toggle="tab" href="#gastos" role="tab">Gastos Fijos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="operarios-tab" data-bs-toggle="tab" href="#operarios" role="tab">Categorías de Operarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="constantes-tab" data-bs-toggle="tab" href="#constantes" role="tab">Constantes Globales</a>
        </li>
    </ul>

    <div class="tab-content mt-4" id="configTabsContent">
        <!-- Gastos Fijos -->
        <div class="tab-pane fade show active" id="gastos" role="tabpanel">
            @include('configuracion.gastos_fijos._tabla', ['gastos' => $gastosFijos ?? []])
        </div>
    
        <!-- Categorías de Operarios -->
        <div class="tab-pane fade" id="operarios" role="tabpanel">
            @include('configuracion.operarios._tabla', ['categorias' => $categoriasOperarios ?? []])
        </div>
    
        <!-- Constantes Globales -->
        <div class="tab-pane fade" id="constantes" role="tabpanel">
            @include('configuracion.constantes._tabla', ['constantes' => $constantesGlobales ?? []])
        </div>
    </div>
    
@endsection
