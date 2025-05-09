<!-- Resumen Totales -->
<h4 class="mt-5">Resumen Final</h4>

<div class="table-responsive">
  <table class="table table-bordered">
    <tbody>
      <tr><th>Subtotal Mano de Obra</th>
        <td><span id="subtotal_mo">${{ number_format($presupuesto->subtotal_mano_obra ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>Subtotal Materiales</th>
        <td><span id="subtotal_materiales">${{ number_format($presupuesto->subtotal_materiales ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>Subtotal Gastos Fijos</th>
        <td><span id="subtotal_gastos">${{ number_format($presupuesto->subtotal_gastos_fijos ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>Utilidad</th>
        <td><span id="utilidad_monto">${{ number_format($presupuesto->utilidad_monto ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>Subtotal General</th>
        <td><span id="subtotal_general">${{ number_format($presupuesto->subtotal_general ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>IVA (22%)</th>
        <td><span id="iva">${{ number_format($presupuesto->iva_monto ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>BPS</th>
        <td><span id="bps_monto">${{ number_format($presupuesto->bps_monto ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr class="table-success fw-bold"><th>Total Final</th>
        <td><span id="total_final">${{ number_format($presupuesto->total_final ?? 0, 2, ',', '.') }}</span></td>
      </tr>
      <tr><th>Precio por m² (general)</th>
        <td><span id="precioPorM2">—</span></td>
      </tr>
      <tr><th>% Utilidad sobre MO + Materiales</th>
        <td><span id="porcentajeUtilidadSobreCostos">—</span></td>
      </tr>
      <tr><th>% Utilidad sobre mano de obra</th>
        <td><span id="porcentajeUtilidad">—</span></td>
      </tr>
    </tbody>
  </table>




