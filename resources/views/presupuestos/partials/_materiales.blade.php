<h4 class="mt-4">Materiales</h4>

<div class="d-flex gap-2 mb-2">
  <button class="btn btn-secondary mb-2" type="button" onclick="agregarFilaMateriales(this)">
      ➕ Agregar Fila
  </button>


</div>

<div class="table-responsive">
  <table id="tablaMateriales" class="table table-bordered  tabla-materiales">
    <thead>
      <tr>
        <th>ID Tarea</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Manos</th>
        <th>Rendimiento</th>
        <th>Litros por Lata</th>
        <th>Costo Unitario</th>
        <th>Latas</th>
        <th>Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        ?>
      @forelse ($presupuesto->materiales as $i => $material)
        <tr>
          {{-- Hidden fields --}}
          <input type="hidden" name="materiales[{{ $i }}][id]" value="{{ $material->id }}">
          <input type="hidden" name="materiales[{{ $i }}][eliminar]" value="0" class="eliminar-material">

          <td width="80">
            <input class="form-control material_id_tarea" name="materiales[{{ $i }}][orden]" type="number" value="{{ old('materiales.' . $i . '.orden', $material->orden ?? 1) }}">
          </td>

          <td>
            <input class="form-control material-descripcion" name="materiales[{{ $i }}][descripcion]" type="text" value="{{ $material->descripcion }}">
          </td>

          <td width="60">
            <input class="form-control material-cantidad" name="materiales[{{ $i }}][cantidad_unidades]" type="number" value="{{ $material->cantidad_unidades }}">
          </td>

          <td>
            <input class="form-control material-manos" name="materiales[{{ $i }}][manos]" type="number" value="{{ $material->manos }}">
          </td>

          <td>
            <input class="form-control material-rendimiento" name="materiales[{{ $i }}][rendimiento]" type="number" value="{{ $material->rendimiento }}">
          </td>

          <td>
            <input class="form-control material-litros" name="materiales[{{ $i }}][litros_por_lata]" type="number" value="{{ $material->litros_por_lata }}">
          </td>

          <td>
            <input class="form-control material-costo" name="materiales[{{ $i }}][costo_unitario]" type="number" value="{{ $material->costo_unitario }}">
          </td>

          <td class="latas">—</td>

          @php
            $totalFila = 0;
            if (!empty($material->manos) && !empty($material->rendimiento) && $material->rendimiento>0 && !empty($material->litros_por_lata) && $material->litros_por_lata > 0) {
                $cantLatas = ceil(($material->manos * $material->cantidad_unidades) / $material->rendimiento / $material->litros_por_lata);
                $totalFila = $cantLatas * $material->costo_unitario;
            } else {
                $totalFila = $material->cantidad_unidades * $material->costo_unitario;
            }
            $total += $totalFila;
        @endphp
        <td class="totalFila" data-total="{{ $totalFila }}">
            $ {{ number_format($totalFila, 2, ',', '.') }}
        </td>

          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🗑️</button>
          </td>
        </tr>
      @empty
        <tr>
          <td width="80">
            <input class="form-control material_id_tarea" name="materiales[0][orden]" type="number" value="1">
          </td>

          <td>
            <input class="form-control material-descripcion" name="materiales[0][descripcion]" type="text">
          </td>

          <td>
            <input class="form-control material-cantidad" name="materiales[0][cantidad_unidades]" type="number" value="0">
          </td>

          <td>
            <input class="form-control material-manos" name="materiales[0][manos]" type="number" value="0">
          </td>

          <td>
            <input class="form-control material-rendimiento" name="materiales[0][rendimiento]" type="number" value="0">
          </td>

          <td>
            <input class="form-control material-litros" name="materiales[0][litros_por_lata]" type="number" value="0">
          </td>

          <td>
            <input class="form-control material-costo" name="materiales[0][costo_unitario]" type="number" value="0">
          </td>

          <td class="latas">—</td>

          <td class="totalFila" data-total="0">$ 0,00</td>

          <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🗑️</button>
          </td>
        </tr>
      @endforelse
    </tbody>

    <tfoot>
      <tr>
        <td colspan="8" class="text-end fw-bold">Total Materiales:</td>
        <td id="totalMaterialesTabla" class="fw-bold">$ {{ $total }}</td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>
