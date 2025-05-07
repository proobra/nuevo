{{-- Mano de Obra --}}
<h4 class="mt-4">Mano de Obra</h4>

<div class="d-flex gap-2 mb-2">
  <button class="btn btn-light w-25" type="button" onclick="agregarFilaManoDeObra(this)">
      ➕ Agregar Fila
  </button>

  <button type="submit" class="btn btn-light w-75">
      💾 Guardar Presupuesto
  </button>
</div>
<div class="table-responsive">
  <table id="tablaManoDeObra" class="table table-bordered tabla-mano-obra">

    <thead>
      <tr>
        <th>ID Tarea</th>
        <th>Fila</th>
        <th>Comentario</th>
        <th>Categoría</th>
        <th>Cantidad</th>
        <th>Días</th>
        <th>Jornal</th>
        <th>Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($presupuesto->manoDeObra as $i => $obra)
        <tr class="fila-mano-obra mano-obra-fila">
          <input type="hidden" name="obra_id[]" value="{{ $obra->id }}">
          <input type="hidden" name="obra_eliminar[]" value="0">
    
          <td><input class="form-control obra_id_tarea" name="obra_id_tarea[]" type="number" value="{{ $obra->replanteo->orden ?? 1 }}"></td>
          <td class="text-center"><input class="form-control text-center" style="width: 40px;" name="obra_fila[]" type="number" value="{{ $i + 1 }}" readonly></td>
          <td><input class="form-control obra_comentario" name="obra_comentario[]" type="text" value="{{ $obra->comentario }}"></td>
          <td>
            <select class="form-select obra_categoria" name="obra_categoria[]">
              @foreach($laudos as $laudo)
                <option value="{{ $laudo->categoria }}"
                  data-jornal-total="{{ $laudo->total_jornal ?? $laudo->laudo_base }}"
                  data-laudo-base="{{ $laudo->laudo_base ?? 0 }}"
                  @selected($laudo->categoria === $obra->categoria)>
                  {{ $laudo->categoria }}
                </option>
              @endforeach
            </select>
          </td>
          <td><input class="form-control obra_cantidad" name="obra_cantidad[]" type="number" step="0.01" value="{{ $obra->cantidad }}"></td>
          <td><input class="form-control obra_dias" name="obra_dias[]" type="number" step="0.01" value="{{ $obra->dias }}"></td>
          <td><input class="form-control valor-jornal" name="obra_valor_jornal[]" type="number" step="0.01" value="{{ number_format($obra->valor_jornal, 2, '.', '') }}" readonly></td>
          <td class="totalObra" data-total="{{ $obra->valor_jornal * $obra->cantidad * $obra->dias }}">
            $ {{ number_format($obra->valor_jornal * $obra->cantidad * $obra->dias, 2, ',', '.') }}
          </td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🖑️</button></td>
        </tr>
      @empty
        <tr class="fila-mano-obra mano-obra-fila">
          <input type="hidden" name="obra_id[]" value="">
          <input type="hidden" name="obra_eliminar[]" value="0">
    //Cometario Git
          <td><input class="form-control obra_id_tarea" name="obra_id_tarea[]" type="number" value="1"></td>
          <td class="text-center"><input class="form-control text-center" style="width: 40px;" name="obra_fila[]" type="number" value="1" readonly></td>
          <td><input class="form-control obra_comentario" name="obra_comentario[]" type="text" value=""></td>
          <td>
            <select class="form-select obra_categoria" name="obra_categoria[]">
              @foreach($laudos as $laudo)
                <option value="{{ $laudo->categoria }}"
                  data-jornal-total="{{ $laudo->total_jornal ?? $laudo->laudo_base }}"
                  data-laudo-base="{{ $laudo->laudo_base ?? 0 }}">
                  {{ $laudo->categoria }}
                </option>
              @endforeach
            </select>
          </td>
          <td><input class="form-control obra_cantidad" name="obra_cantidad[]" type="number" step="0.01" value="0"></td>
          <td><input class="form-control obra_dias" name="obra_dias[]" type="number" step="0.01" value="0"></td>
          <td><input class="form-control valor-jornal" name="obra_valor_jornal[]" type="number" step="0.01" value="0.00" readonly></td>
          <td class="totalObra" data-total="0">$ 0,00</td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🖑️</button></td>
        </tr>
      @endforelse
    </tbody>
    

    <tfoot>
      <tr>
        <td colspan="7" class="text-end"><strong>Total mano de obra:</strong></td>
        <td id="totalManoDeObraTabla" class="fw-bold">$ 0,00</td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>
