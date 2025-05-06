<script>

    // 🧮 Función principal para actualizar el resumen de un formulario
    window.updateResumenFinal = function (formulario) {
        if (!formulario) return; // Si no hay form, salir
    
        let totalManoDeObra = 0;
        let totalMateriales = 0;
        let totalGastosFijos = 0;
        let utilidad = 0;
        let superficie = parseFloatOrZero(formulario.querySelector('#superficie')?.value);
    
        // 🛠 Mano de Obra
        formulario.querySelectorAll('.mano-obra-fila').forEach(fila => {
            const cantidad = parseFloatOrZero(fila.querySelector('.obra_cantidad')?.value);
            const dias = parseFloatOrZero(fila.querySelector('.obra_dias')?.value);
            const selectCategoria = fila.querySelector('.obra_categoria');
            const jornal = parseFloatOrZero(selectCategoria?.selectedOptions[0]?.dataset.jornalTotal);
            const total = cantidad * dias * jornal;
    
            totalManoDeObra += total;
    
            const inputJornal = fila.querySelector('.valor-jornal');
            if (inputJornal) {
                inputJornal.value = jornal.toFixed(2);
            }
    
            const totalObraCell = fila.querySelector('.totalObra');
            if (totalObraCell) {
                totalObraCell.dataset.total = total.toFixed(2);
                totalObraCell.textContent = `$ ${total.toFixed(2).replace('.', ',')}`;
            }
        });
    
        const totalTablaMO = formulario.querySelector('#totalManoDeObraTabla');
        if (totalTablaMO) {
            totalTablaMO.textContent = `$ ${totalManoDeObra.toFixed(2).replace('.', ',')}`;
        }
    
        // 🧱 Materiales
        formulario.querySelectorAll('#tablaMateriales tbody tr').forEach(fila => {
            const unidades = parseFloatOrZero(fila.querySelector('[name*="[cantidad_unidades]"]')?.value);
            const manos = parseFloatOrZero(fila.querySelector('[name*="[manos]"]')?.value);
            const rendimiento = parseFloatOrZero(fila.querySelector('[name*="[rendimiento]"]')?.value);
            const litros = parseFloatOrZero(fila.querySelector('[name*="[litros_por_lata]"]')?.value);
            const costo = parseFloatOrZero(fila.querySelector('[name*="[costo_unitario]"]')?.value);
    
            let totalFila = 0;
            let cantLatas = 0;
    
            if (manos && rendimiento && litros) {
                const calculo = (manos * unidades) / rendimiento / litros;
                cantLatas = Math.ceil(calculo);
                totalFila = cantLatas * costo;
            } else {
                totalFila = unidades * costo;
            }
    
            const celdaTotal = fila.querySelector('.totalFila');
            if (celdaTotal) {
                celdaTotal.dataset.total = totalFila.toFixed(2);
                celdaTotal.textContent = `$ ${totalFila.toFixed(2).replace('.', ',')}`;
            }
    
            const celdaLatas = fila.querySelector('.latas');
            if (celdaLatas) {
                celdaLatas.textContent = cantLatas > 0 ? cantLatas : '—';
            }
    
            totalMateriales += totalFila;
        });
    
        const totalTablaMateriales = formulario.querySelector('#totalMaterialesTabla');
        if (totalTablaMateriales) {
            totalTablaMateriales.textContent = `$ ${totalMateriales.toFixed(2).replace('.', ',')}`;
        }
    
        // 💰 Gastos Fijos
        const desgloseGastos = [];
        formulario.querySelectorAll('.gasto-fijo').forEach(input => {
            if (input.checked && input.value !== "1") { // Excluye el IVA
                const contenedor = input.closest('.form-check');
                const nombre = contenedor.querySelector('label')?.textContent.trim();
                const valor = parseFloatOrZero(contenedor.querySelector('[name="gasto_valor[]"]')?.value);
                const cantidad = parseFloatOrZero(contenedor.querySelector('[name="gasto_cantidad[]"]')?.value);
                const monto = cantidad > 0 ? valor * cantidad : valor;
    
                totalGastosFijos += monto;
                desgloseGastos.push({ nombre, monto });
            }
        });
    
        // 🟨 Utilidad
        const porcentajeUtilidad = parseFloatOrZero(formulario.querySelector('#utilidad')?.value);
        utilidad = totalManoDeObra * (porcentajeUtilidad / 100);
    
        // 🔵 IVA
        const checkboxIVA = formulario.querySelector('.gasto-fijo[value="1"]'); // ID=1 => IVA
        const ivaActivo = checkboxIVA?.checked ?? false;
        const baseIVA = totalManoDeObra + totalMateriales + totalGastosFijos + utilidad;
        const iva = ivaActivo ? baseIVA * 0.22 : 0;
    
        // 🟪 BPS
        let sumaLaudoBase = 0;
        formulario.querySelectorAll('.mano-obra-fila').forEach(fila => {
            const cantidad = parseFloatOrZero(fila.querySelector('.obra_cantidad')?.value);
            const dias = parseFloatOrZero(fila.querySelector('.obra_dias')?.value);
            const selectCategoria = fila.querySelector('.obra_categoria');
            const laudoBase = parseFloatOrZero(selectCategoria?.selectedOptions[0]?.dataset.laudoBase);
    
            sumaLaudoBase += cantidad * dias * laudoBase;
        });
    
        const porcentajeBPS = parseFloatOrZero(formulario.querySelector('#bps_porcentaje')?.value);
        const bps = sumaLaudoBase * porcentajeBPS / 100;
    
        // 🧾 Subtotales
        const subtotal = totalManoDeObra + totalMateriales + totalGastosFijos + utilidad;
        const totalFinal = subtotal + iva + bps;
        const precioPorM2 = superficie > 0 ? totalFinal / superficie : 0;
    
        // ✅ Actualización visual
        const actualizar = (id, valor, sufijo = "$") => {
            const el = formulario.querySelector(`#${id}`);
            if (el) el.textContent = `${sufijo} ${valor.toFixed(2).replace('.', ',')}`;
        };
    
        actualizar('subtotal_mo', totalManoDeObra);
        actualizar('subtotal_materiales', totalMateriales);
        actualizar('subtotal_gastos', totalGastosFijos);
        actualizar('utilidad_monto', utilidad);
        actualizar('bps_monto', bps);
        actualizar('bps_porcentaje', porcentajeBPS, '');
    
        actualizar('subtotal_general', subtotal);
        actualizar('iva', iva);
        actualizar('total_final', totalFinal);
        actualizar('precioPorM2', precioPorM2);
    
        const utilidadSobreMO = totalManoDeObra > 0 ? (utilidad / totalManoDeObra) * 100 : 0;
        const utilidadSobreCostos = (totalManoDeObra + totalMateriales) > 0 ? (utilidad / (totalManoDeObra + totalMateriales)) * 100 : 0;
    
        actualizar('porcentajeUtilidad', utilidadSobreMO, '');
        actualizar('porcentajeUtilidadSobreCostos', utilidadSobreCostos, '');
    }
    
    // 🔢 Función auxiliar segura
    function parseFloatOrZero(valor) {
        const n = parseFloat(valor);
        return isNaN(n) ? 0 : n;
    }
    
    // 🚀 Al cargar el DOM recalculamos todos los presupuestos
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form.presupuesto-form').forEach(formulario => {
            updateResumenFinal(formulario);
        });
    
        // 🔄 Refrescar automáticamente la categoría al cargar
        document.querySelectorAll('.mano-obra-fila').forEach(fila => {
            const select = fila.querySelector('.obra_categoria');
            if (select) {
                const event = new Event('change');
                select.dispatchEvent(event);
            }
        });
    });
    
    // ✍️ Cada vez que el usuario cambia un dato
    document.addEventListener('input', (e) => {
        if (
            e.target.classList.contains('obra_cantidad') ||
            e.target.classList.contains('obra_dias') ||
            e.target.classList.contains('valor-jornal') ||
            e.target.classList.contains('material-cantidad') ||
            e.target.classList.contains('material-costo') ||
            e.target.classList.contains('gasto-fijo') ||
            e.target.name === 'gasto_valor[]' ||
            e.target.name === 'gasto_cantidad[]' ||
            e.target.id === 'utilidad' ||
            e.target.id === 'bps_porcentaje' ||
            e.target.id === 'superficie'
        ) {
            const formulario = e.target.closest('form.presupuesto-form');
            updateResumenFinal(formulario);
        }
    });
    
    </script>
    