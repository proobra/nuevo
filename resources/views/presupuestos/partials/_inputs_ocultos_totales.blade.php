<!-- partials/_inputs_ocultos_totales.blade.php -->

{{-- Inputs ocultos para enviar los totales al controlador --}}
<input type="hidden" id="input_subtotal_mano_obra" name="subtotal_mano_obra" value="{{ $presupuesto->subtotal_mano_obra ?? 0 }}">
<input type="hidden" id="input_subtotal_materiales" name="subtotal_materiales" value="{{ $presupuesto->subtotal_materiales ?? 0 }}">
<input type="hidden" id="input_subtotal_gastos_fijos" name="subtotal_gastos_fijos" value="{{ $presupuesto->subtotal_gastos_fijos ?? 0 }}">
<input type="hidden" id="input_utilidad_monto" name="utilidad_monto" value="{{ $presupuesto->utilidad_monto ?? 0 }}">
<input type="hidden" id="input_subtotal_general" name="subtotal_general" value="{{ $presupuesto->subtotal_general ?? 0 }}">
<input type="hidden" id="input_iva_monto" name="iva_monto" value="{{ $presupuesto->iva_monto ?? 0 }}">
<input type="hidden" id="input_bps_monto" name="bps_monto" value="{{ $presupuesto->bps_monto ?? 0 }}">
<input type="hidden" id="input_total_final" name="total_final" value="{{ $presupuesto->total_final ?? 0 }}">
<input type="hidden" id="input_precio_por_m2" name="precio_por_m2" value="{{ $presupuesto->precio_por_m2 ?? 0 }}">
<input type="hidden" id="input_porcentaje_utilidad_sobre_costos" name="porcentaje_utilidad_sobre_costos" value="{{ $presupuesto->porcentaje_utilidad_sobre_costos ?? 0 }}">
<input type="hidden" id="input_porcentaje_utilidad" name="porcentaje_utilidad" value="{{ $presupuesto->porcentaje_utilidad ?? 0 }}">


