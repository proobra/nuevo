<script>
    var parseFloatOrZero = (v) => isNaN(parseFloat(v)) ? 0 : parseFloat(v);

    // ============ FUNCIONES DE AGREGAR FILAS =============

    window.agregarFilaReplanteo = function (boton) {

    const formulario = boton.closest('form');
    const tabla = formulario.querySelector('#tablaReplanteo tbody');
    const filas = tabla.querySelectorAll('tr');
    const ultimaFila = filas[filas.length - 1];

    const nuevaFila = ultimaFila.cloneNode(true);

    const nuevoIndex = filas.length; // cantidad de filas actuales

    // Actualizar INPUTS en la nueva fila
    nuevaFila.querySelectorAll('input').forEach(input => {

        const name = input.getAttribute('name');
        if (name) {

            const nuevoName = name.replace(/\[\d+\]/, `[${nuevoIndex}]`);
            input.setAttribute('name', nuevoName);

            if (name.includes('[id]')) {
                input.value = ''; // borrar id
            } else if (name.includes('orden')) {
                input.value = parseInt(input.value) + 1; // orden correlativo (1,2,3)
            } else if (name.includes('[fila_orden_interno]')) {
                input.value = nuevoIndex + 1; // fila interna correlativa
            } else if (name.includes('[eliminar]')) {
                input.value = 0;
            } else {
                input.value = ''; // limpiar otros campos
            }
        }
    });
    nuevaFila.style.display = '';
    tabla.appendChild(nuevaFila);
    console.log('nuevaFila',nuevaFila);

    updateResumenFinal(formulario);
};





window.agregarFilaMateriales = function (boton) {
    const formulario = boton.closest('form');
    const tabla = formulario.querySelector('#tablaMateriales tbody');
    const filas = tabla.querySelectorAll('tr');
    const ultimaFila = filas[filas.length - 1];
    const nuevaFila = ultimaFila.cloneNode(true);

    const nuevoIndex = filas.length; // cantidad de filas actuales

    nuevaFila.querySelectorAll('input').forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
            const nuevoName = name.replace(/\[\d+\]/, `[${nuevoIndex}]`);
            if (nuevoName !== name) {
                input.setAttribute('name', nuevoName);
            }

            if (name.includes('[id]')) {
                input.value = ''; // Borrar ID
            } else if (name.includes('[orden]')) {
                input.value = 1; // Orden por defecto 1
            } else if (name.includes('[eliminar]')) {
                input.value = 0; // Siempre 0 para nuevas filas
            } else {
                input.value = ''; // Limpiar otros campos
            }
        }
    });

    const totalCell = nuevaFila.querySelector('.totalFila');
    if (totalCell) {
        totalCell.dataset.total = "0";
        totalCell.textContent = "$ 0,00";
    }

    const latasCell = nuevaFila.querySelector('.latas');
    if (latasCell) {
        latasCell.textContent = "—";
    }
    nuevaFila.style.display = '';
    tabla.appendChild(nuevaFila);

    // 🔥 Nueva línea para forzar actualizar los totales después de agregar fila
    updateResumenFinal(formulario);
};


 window.agregarFilaManoDeObra = function (boton) {
    const formulario = boton.closest('form');
    const tabla = formulario.querySelector('.tabla-mano-obra tbody');
    const filas = tabla.querySelectorAll('tr');
    const ultimaFila = filas[filas.length - 1];
    const nuevaFila = ultimaFila.cloneNode(true);

    const nuevoIndex = filas.length;

    nuevaFila.querySelectorAll('input, select').forEach(input => {
        if (input.name) {
            input.name = input.name.replace(/\[\d+\]/, `[${nuevoIndex}]`);
        }

        if (input.classList.contains('obra_id_tarea')) {
            input.value = 1; // ID Tarea 1 por defecto
        } else if (input.name.includes('[fila_orden_interno]')) {
            input.value = nuevoIndex + 1; // Fila incremental
        } else if (input.name.includes('[eliminar]')) {
            input.value = 0;
        } else if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        } else {
            input.value = '';
        }
    });

    const totalCell = nuevaFila.querySelector('.totalObra');
    if (totalCell) {
        totalCell.dataset.total = "0";
        totalCell.textContent = "$ 0,00";
    }
    nuevaFila.style.display = '';
    tabla.appendChild(nuevaFila);

    updateResumenFinal(formulario);
};



    // ============ FUNCIÓN DE ELIMINAR FILAS =============

    window.eliminarFila = function (boton) {
        const fila = boton.closest('tr');
        const tabla = fila.closest('table');
        const tbody = tabla.querySelector('tbody');

        const totalFilas = tbody.querySelectorAll('tr:not([style*="display: none"])').length;

        if (totalFilas <= 1) {
            alert('Debe haber al menos una fila en esta sección.');
            return;
        }

        const inputEliminar = fila.querySelector('input[name*="[eliminar]"]');
        if (inputEliminar) {
            inputEliminar.value = 1;
        }

        fila.style.display = 'none';

        updateResumenFinal();

    };

    // ============ FUNCIÓN PRINCIPAL DE CÁLCULOS =============

    window.updateResumenFinal = function (formulario) {
    if (!formulario) return;

    let totalManoDeObra = 0;
    let totalMateriales = 0;
    let totalGastosFijos = 0;
    let utilidad = 0;
    const superficie = parseFloatOrZero(formulario.querySelector('#superficie')?.value);

    // 🛠 Mano de Obra
    formulario.querySelectorAll('.mano-obra-fila').forEach(fila => {
        const cantidad = parseFloatOrZero(fila.querySelector('.obra_cantidad')?.value);
        const dias = parseFloatOrZero(fila.querySelector('.obra_dias')?.value);
        const jornal = parseFloatOrZero(fila.querySelector('.obra_categoria')?.selectedOptions[0]?.dataset.jornalTotal);

        const total = cantidad * dias * jornal;
        totalManoDeObra += total;

        const inputJornal = fila.querySelector('.valor-jornal');
        if (inputJornal) inputJornal.value = jornal.toFixed(2);

        const totalObraCell = fila.querySelector('.totalObra');
        if (totalObraCell) {
            totalObraCell.dataset.total = total.toFixed(2);
            totalObraCell.textContent = `$ ${total.toFixed(2).replace('.', ',')}`;
        }
    });

    // 🧱 Materiales
    formulario.querySelectorAll('.tabla-materiales tbody tr').forEach(fila => {
        const unidades = parseFloatOrZero(fila.querySelector('.material-cantidad')?.value);
        const manos = parseFloatOrZero(fila.querySelector('.material-manos')?.value);
        const rendimiento = parseFloatOrZero(fila.querySelector('.material-rendimiento')?.value);
        const litros = parseFloatOrZero(fila.querySelector('.material-litros')?.value);
        const costo = parseFloatOrZero(fila.querySelector('.material-costo')?.value);

        let totalFila = 0;
        let cantLatas = 0;

        if (manos && rendimiento && litros) {
            cantLatas = Math.ceil((manos * unidades) / rendimiento / litros);
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
        if (celdaLatas) celdaLatas.textContent = cantLatas > 0 ? cantLatas : '—';

        totalMateriales += totalFila;
    });




    // Total Materiales en la tabla
const totalTablaMateriales = formulario.querySelector('#totalMaterialesTabla');
if (totalTablaMateriales) {
    totalTablaMateriales.textContent = `$ ${totalMateriales.toFixed(2).replace('.', ',')}`;
}

// Total Mano de Obra en la tabla
const totalTablaMO = formulario.querySelector('#totalManoDeObraTabla');
if (totalTablaMO) {
    totalTablaMO.textContent = `$ ${totalManoDeObra.toFixed(2).replace('.', ',')}`;
}






    // 💰 Gastos Fijos
    formulario.querySelectorAll('.gasto-fijo').forEach(input => {
        if (input.checked && input.value !== "1") {
            const contenedor = input.closest('.form-check');
            const valor = parseFloatOrZero(contenedor.querySelector('[name="gasto_valor[]"]')?.value);
            const cantidad = parseFloatOrZero(contenedor.querySelector('[name="gasto_cantidad[]"]')?.value);
            totalGastosFijos += cantidad > 0 ? valor * cantidad : valor;
        }
    });

    // 🟨 Utilidad
    const porcentajeUtilidad = parseFloatOrZero(formulario.querySelector('#utilidad')?.value);
    utilidad = totalManoDeObra * (porcentajeUtilidad / 100);

    // 🔵 IVA
    const ivaActivo = formulario.querySelector('.gasto-fijo[value="1"]')?.checked ?? false;
    const baseIVA = totalManoDeObra + totalMateriales + totalGastosFijos + utilidad;
    const iva = ivaActivo ? baseIVA * 0.22 : 0;

    // 🟪 BPS
    let sumaLaudoBase = 0;
    formulario.querySelectorAll('.mano-obra-fila').forEach(fila => {
        const cantidad = parseFloatOrZero(fila.querySelector('.obra_cantidad')?.value);
        const dias = parseFloatOrZero(fila.querySelector('.obra_dias')?.value);
        const laudoBase = parseFloatOrZero(fila.querySelector('.obra_categoria')?.selectedOptions[0]?.dataset.laudoBase);
        sumaLaudoBase += cantidad * dias * laudoBase;
    });
    const porcentajeBPS = parseFloatOrZero(formulario.querySelector('#bps_porcentaje')?.value);
    const bps = sumaLaudoBase * porcentajeBPS / 100;

    const subtotal = totalManoDeObra + totalMateriales + totalGastosFijos + utilidad;
    const totalFinal = subtotal + iva + bps;
    const precioPorM2 = superficie > 0 ? totalFinal / superficie : 0;

    // ✅ Actualizar DOM

    const actualizar = (id, valor, sufijo = "$") => {
        const el = formulario.querySelector(`#${id}`);
        if (el) el.textContent = `${sufijo} ${valor.toFixed(2).replace('.', ',')}`;
    };

    actualizar('subtotal_mo', totalManoDeObra);
    actualizar('subtotal_materiales', totalMateriales);
    actualizar('subtotal_gastos', totalGastosFijos);
    actualizar('utilidad_monto', utilidad);
    actualizar('bps_monto', bps);
    actualizar('subtotal_general', subtotal);
    actualizar('iva', iva);
    actualizar('total_final', totalFinal);
    actualizar('precioPorM2', precioPorM2);

    const utilidadSobreMO = totalManoDeObra > 0 ? (utilidad / totalManoDeObra) * 100 : 0;
    const utilidadSobreCostos = (totalManoDeObra + totalMateriales) > 0 ? (utilidad / (totalManoDeObra + totalMateriales)) * 100 : 0;

    actualizar('porcentajeUtilidad', utilidadSobreMO, '');
    actualizar('porcentajeUtilidadSobreCostos', utilidadSobreCostos, '');

    // 📝 Actualizar también inputs ocultos
    const actualizarInput = (id, valor) => {
        const input = formulario.querySelector(`#input_${id}`);
        if (input) input.value = valor.toFixed(2);
    };

    actualizarInput('subtotal_mano_obra', totalManoDeObra);
    actualizarInput('subtotal_materiales', totalMateriales);
    actualizarInput('subtotal_gastos_fijos', totalGastosFijos);
    actualizarInput('utilidad_monto', utilidad);
    actualizarInput('subtotal_general', subtotal);
    actualizarInput('iva_monto', iva);
    actualizarInput('bps_monto', bps);
    actualizarInput('total_final', totalFinal);
    actualizarInput('precio_por_m2', precioPorM2);
    actualizarInput('porcentaje_utilidad', utilidadSobreMO);
    actualizarInput('porcentaje_utilidad_sobre_costos', utilidadSobreCostos);
};


// Boton guardar
window.beforeSubmit = function (formulario) {
    if (formulario) {
        updateResumenFinal(formulario); // 💥 Calcula todo antes de enviar
    }
};


    // ============ EVENTOS =============

    document.addEventListener('input', (e) => {
    const formulario = e.target.closest('form');
    if (!formulario) return;

    if (
        e.target.classList.contains('obra_cantidad') ||
        e.target.classList.contains('obra_dias') ||
        e.target.classList.contains('obra_categoria') ||
        e.target.classList.contains('material-cantidad') ||
        e.target.classList.contains('material-costo') ||
        e.target.classList.contains('gasto-fijo') ||
        e.target.name === 'gasto_valor[]' ||
        e.target.name === 'gasto_cantidad[]' ||
        e.target.id === 'utilidad' ||
        e.target.id === 'bps_porcentaje' ||
        e.target.id === 'superficie'
    ) {
        updateResumenFinal(formulario);
    }
});




    </script>

