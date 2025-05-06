{{-- ========================= --}}
{{-- PRESUPUESTO HIJO COMPLETO --}}
{{-- ========================= --}}

<div class="card my-5 p-4" style="background-color: #f8f9fa;">

    {{-- ✅ Título del Hijo --}}
    <h4 class="text-center mb-4">
        Presupuesto Hijo: PPTO{{ $hijo->id }} {{ $hijo->titulo }}
    </h4>

    {{-- ✅ Formulario propio del hijo --}}
    <form class="presupuesto-form-hijo" action="{{ route('presupuestos.update', $hijo->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Datos Cliente e Información de Obra del Hijo --}}
        @include('presupuestos.partials.datos_cliente', ['presupuesto' => $hijo])
        @include('presupuestos.partials.datos_obra', ['presupuesto' => $hijo])

        {{-- Tablas del Hijo --}}
        @include('presupuestos.partials._replanteo', ['presupuesto' => $hijo])
        @include('presupuestos.partials._materiales', ['presupuesto' => $hijo])
        @include('presupuestos.partials._mano_obra', ['presupuesto' => $hijo])
        @include('presupuestos.partials._gastos', ['presupuesto' => $hijo, 'gastosFijos' => $gastosFijos])

        {{-- Resumen de Totales del Hijo --}}
        @include('presupuestos.partials._resumen_totales', ['presupuesto' => $hijo])

        {{-- ✅ Botones individuales del Hijo --}}
        <div class="d-flex flex-wrap justify-content-center gap-2 my-3">
            <button type="submit" class="btn btn-primary" style="min-width: 150px;">
                💾 Guardar Hijo
            </button>
            <a href="{{ route('presupuestos.edit', $hijo->presupuesto_padre_id) }}" class="btn btn-secondary" style="min-width: 150px;">
                🔙 Volver al Padre
            </a>
        </div>

        {{-- Inputs ocultos del Hijo para Totales --}}
        @include('presupuestos.partials._inputs_ocultos_totales', ['presupuesto' => $hijo])

    </form>

</div>
