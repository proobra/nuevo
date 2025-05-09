@extends('layouts.app') {{-- o quitá esta línea si no usás layout --}}

@section('content')
<div class="container mt-5">
    <form class="presupuesto-form">

        <h4 class="mt-4">Mano de Obra</h4>
        <button class="btn btn-secondary mb-2" type="button" onclick="agregarFilaManoDeObra()">Agregar fila</button>

        <div class="table-responsive">
            <table class="table table-bordered" id="tablaManoDeObra">
                <thead>
                    <tr>
                        <th>ID Tarea</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Días</th>
                        <th>Jornal</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="mano-obra-fila">
                        <td>
                            <input type="hidden" name="obra_id[]" value="">
                            <input class="form-control obra_id_tarea" name="obra_id_tarea[]" type="number" value="1">
                        </td>
                        <td>
                            <select class="form-select obra_categoria" name="obra_categoria[]">
                                <option value="Peón IV" data-jornal-total="1200">Peón IV</option>
                                <option value="Medio Oficial V" data-jornal-total="1500">Medio Oficial V</option>
                                <option value="Oficial VIII" data-jornal-total="1800">Oficial VIII</option>
                            </select>
                        </td>
                        <td><input class="form-control obra_cantidad" name="obra_cantidad[]" type="number" step="0.01" value="1"></td>
                        <td><input class="form-control obra_dias" name="obra_dias[]" type="number" step="0.01" value="1"></td>
                        <td><input class="form-control valor-jornal" name="obra_valor_jornal[]" type="number" step="0.01" value="0.00" readonly></td>
                        <td class="totalObra" data-total="0">$ 0,00</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <strong>Total Mano de Obra: $ <span class="total-mano">0.00</span></strong>
        </div>
    </form>
</div>
@include('partials.scripts')
@endsection
