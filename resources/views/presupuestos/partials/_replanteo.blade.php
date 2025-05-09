{{-- Replanteo de Tareas --}}

 <h4 class="mt-4">Replanteo de Tareas</h4>
 <div class="d-flex gap-2 mb-2">


<button class="btn btn-secondary mb-2" type="button" onclick="agregarFilaReplanteo(this)">
    ➕ Agregar Filas
</button>

</div>

<div class="table-responsive">
  <table id="tablaReplanteo" class="table table-bordered tabla-replanteo">

    <thead>
      <tr>
        <th>Orden</th>
        <th>Descripción de la Tarea</th>
        <th>m2</th>
        <th>Días</th>
        <th>Observaciones</th>
        <th>Acciones</th>
      </tr>
    </thead>

    <tbody>

      @forelse ($presupuesto->replanteos as $i => $tarea)
        <tr>
          <!-- Hidden Inputs -->
          <input type="hidden" name="replanteo_id[]" value="{{ $tarea->id }}">
          <input type="hidden" name="replanteo_eliminar[]" value="0" class="eliminar-material">

          <!-- Orden -->
          <td>
            <input type="number" name="replanteo_orden[]" class="form-control" value="{{ $tarea->orden }}">
          </td>

          <!-- Descripción -->
          <td>
            <input type="text" name="replanteo_descripcion[]" class="form-control" value="{{ $tarea->descripcion_tarea }}">
          </td>

          <!-- m2 -->
          <td>
            <input type="number" step="0.01" name="replanteo_metros2[]" class="form-control" value="{{ $tarea->m2 }}">
          </td>

          <!-- Días -->
          <td>
            <input type="number" step="0.01" name="replanteo_dias[]" class="form-control" value="{{ $tarea->dias }}">
          </td>

          <!-- Observaciones -->
          <td>
            <input type="text" name="replanteo_observaciones[]" class="form-control" value="{{ $tarea->observaciones }}">
          </td>

          <!-- Acciones -->
          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🗑️</button>
          </td>
        </tr>
      @empty
        <tr>
          <input type="hidden" name="replanteo_id[]" value="">
          <input type="hidden" name="replanteo_eliminar[]" value="0" class="eliminar-material">

          <td>
            <input type="number" name="replanteo_orden[]" class="form-control" value="1">
          </td>

          <td>
            <input type="text" name="replanteo_descripcion[]" class="form-control" value="">
          </td>

          <td>
            <input type="number" step="0.01" name="replanteo_metros2[]" class="form-control" value="0">
          </td>

          <td>
            <input type="number" step="0.01" name="replanteo_dias[]" class="form-control" value="0">
          </td>

          <td>
            <input type="text" name="replanteo_observaciones[]" class="form-control" value="">
          </td>

          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🗑️</button>
          </td>
        </tr>
      @endforelse
    </tbody>

  </table>
</div>
