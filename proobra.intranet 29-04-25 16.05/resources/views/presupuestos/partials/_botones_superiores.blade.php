{{-- BOTONES SUPERIORES --}}
<div class="p-3 mb-4" style="background-color: #f2f2f2; border-radius: 8px;">

    <div class="d-flex flex-wrap align-items-center gap-2 justify-content-center">
  
      {{-- Dropdown Estado del Presupuesto --}}
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
  
      {{-- Dropdown Acciones --}}
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
  
      {{-- Botón Informe Técnico --}}
      <a href="{{ route('presupuestos.informe_tecnico', $presupuesto->id) }}" 
         class="btn px-4 py-2"
         style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;">
        📄 Informe Técnico
      </a>
  
      {{-- Botón Guardar --}}
      <button type="submit" class="btn px-4 py-2"
              style="background-color: #e0e0e0; border: 1px solid #999; font-weight: bold;">
        💾 Guardar
      </button>
  
      {{-- Botón Agregar Nuevo Hijo (SOLO si no es hijo) --}}
      @if(!$presupuesto->presupuesto_padre_id)
        <a href="{{ route('presupuestos.crear_hijo', $presupuesto->id) }}" 
           class="btn px-4 py-2"
           style="background-color: #d4edda; border: 1px solid #999; font-weight: bold;">
          ➕ Agregar Nuevo Hijo
        </a>
      @endif
  
    </div>
  </div>
  