<div class="card p-3 mb-4">
    <h5 class="mb-3">Datos del cliente</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="empresa" class="form-label">Empresa</label>
            <input type="text" name="empresa" id="empresa" class="form-control"
                   value="{{ old('empresa', $presupuesto->empresa ?? '') }}">
        </div>
        <div class="col-md-6">
            <label for="cliente" class="form-label">Cliente</label>
            <input type="text" name="cliente" id="cliente" class="form-control"
                   value="{{ old('cliente', $presupuesto->cliente ?? '') }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control"
                   value="{{ old('telefono', $presupuesto->telefono ?? '') }}">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', $presupuesto->email ?? '') }}">
        </div>
    </div>

    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" name="direccion" id="direccion" class="form-control"
               value="{{ old('direccion', $presupuesto->direccion ?? '') }}">
    </div>
</div>
