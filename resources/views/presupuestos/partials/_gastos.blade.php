{{-- Gastos Fijos Dinámicos --}}
{{-- Gastos Fijos Dinámicos --}}
<h4 class="mt-4">Gastos Fijos</h4>

<div class="d-flex flex-wrap gap-3 mb-3"><!-- Contenedor de la lista de gastos fijos -->
  @foreach ($gastosFijos as $gasto)
    @php 
      $guardado = isset($presupuesto) 
        ? $presupuesto->gastosFijos->firstWhere('gasto_fijo_id', $gasto->id) 
        : null;
    @endphp

    <div class="form-check">
      <input class="form-check-input gasto-fijo" type="checkbox" 
             name="gasto_seleccionado[]" id="gasto-{{ $gasto->id }}" 
             value="{{ $gasto->id }}" {{ $guardado ? 'checked' : '' }}
             @if($gasto->nombre === 'IMM') 
               onchange="document.getElementById('immCantidad').disabled = !this.checked;" 
             @endif>

      <input type="hidden" name="gasto_fijo_id[]" value="{{ $gasto->id }}">

      @if (!$gasto->editable)
        <input type="hidden" name="gasto_valor[]" value="{{ $gasto->valor }}">
      @endif

      <label class="form-check-label" for="gasto-{{ $gasto->id }}">
        {{ $gasto->nombre }}
        @if ($gasto->nombre === 'IMM')
          (&dollar;{{ number_format($gasto->valor, 2) }}/ml)
        @elseif (!$gasto->editable)
          (&dollar;{{ number_format($gasto->valor, 2) }})
        @endif
      </label>

      @if ($gasto->editable)
        <input type="number" step="0.01" name="gasto_valor[]" 
               class="form-control d-inline-block ms-2" 
               style="width: 80px;"
               value="{{ $guardado->valor_aplicado ?? $gasto->valor }}">
      @endif

      @if ($gasto->nombre === 'IMM')
        <input type="number" step="0.01" name="gasto_cantidad[]" 
               id="immCantidad" class="form-control d-inline-block ms-2" 
               style="width: 80px;" min="0" 
               value="{{ $guardado->cantidad_ml ?? 0 }}" 
               @if(!$guardado) disabled @endif>
      @else
        <input type="hidden" name="gasto_cantidad[]" value="">
      @endif
    </div>
  @endforeach
</div>

{{-- ✅ Inputs fuera de la tabla UTILIDAD - BPS --}}
<div class="d-flex justify-content-center gap-4 mt-4">
  <div class="form-group" style="width: 200px">
    <label for="utilidad">% Utilidad Mano de Obra</label>
    <input type="number" id="utilidad" name="utilidad" class="form-control"
       value="{{ old('utilidad', $presupuesto->utilidad ?? 65) }}"
       min="0" max="999" step="1" oninput="updateResumenFinal()">
  </div>

  <div class="form-group" style="width: 200px">
    <label for="bps_porcentaje">% BPS sobre Mano de Obra</label>
    <input type="number" id="bps_porcentaje" name="bps_porcentaje" class="form-control"
       value="{{ old('bps_porcentaje', $presupuesto->bps_porcentaje ?? '') }}"
       placeholder="Ej: 86"
       min="0" max="100" step="0.1" oninput="updateResumenFinal()">
  </div>
</div>


