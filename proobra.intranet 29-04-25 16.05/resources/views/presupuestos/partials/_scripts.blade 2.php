<script>
    // scripts.blade.php (versión limpia y comentada oficial)

    var form = document.querySelector('form');



function parseFloatOrZero(value) {
    const num = parseFloat(value);
    return isNaN(num) ? 0 : num;
}

// ==========================
// FUNCIONES DE AGREGAR FILAS
// ==========================

window.agregarFilaReplanteo = function () {
    const tabla = document.getElementById('tablaReplanteo');
    if (!tabla) return;

    const tbody = tabla.querySelector('tbody');
    const ultimaFila = tbody.querySelector('tr:last-child');
    const nuevaFila = ultimaFila.cloneNode(true);

    const ordenInput = ultimaFila.querySelector('input[name="replanteo_orden[]"]');
    const nuevoOrden = ordenInput ? parseInt(ordenInput.value || 0) + 1 : 1;

    nuevaFila.querySelectorAll('input').forEach(input => {
        if (input.name === "replanteo_orden[]") {
            input.value = nuevoOrden;
        } else if (input.name === "replanteo_id[]") {
            input.value = '';
        } else if (input.name === "replanteo_eliminar[]") {
            input.value = 0;
        } else {
            input.value = '';
        }
    });

    tbody.appendChild(nuevaFila);
};

window.agregarFilaManoDeObra = function () {
    const tabla = document.getElementById('tablaManoDeObra');
    const tbody = tabla.querySelector('tbody');
    const filas = tbody.querySelectorAll('tr');
    const ultimaFila = filas[filas.length - 1];
    const nuevaFila = ultimaFila.cloneNode(true);

    const nuevoIndex = filas.length;

    nuevaFila.querySelectorAll('input, select').forEach(el => {
        if (el.name) {
            el.name = el.name.replace(/\[\d+\]/, `[${nuevoIndex}]`);
        }

        // Valor por defecto para ID Tarea
        if (el.classList.contains('obra_id_tarea')) {
            el.value = ultimaFila.querySelector('.obra_id_tarea')?.value || 1;
        } else if (el.classList.contains('eliminar-material')) {
            el.value = 0;
        } else if (el.name.includes('[id]')) {
            el.value = ''; // ⚡ Limpiamos el ID oculto para nuevas filas
        } else if (el.tagName === 'SELECT') {
            el.selectedIndex = 0;
        } else {
            el.value = (el.hasAttribute('readonly')) ? 0 : '';
        }
    });


 // 👇 Agregás esto justo después de actualizar los name
 const inputFila = nuevaFila.querySelector('input[name*="[fila_orden_interno]"]');
    if (inputFila) {
        inputFila.value = nuevoIndex + 1; // Que ponga el nuevo número
    }

    const totalCell = nuevaFila.querySelector('.totalObra');
    if (totalCell) {
        totalCell.dataset.total = "0";
        totalCell.textContent = "$ 0,00";
    }

    tbody.appendChild(nuevaFila);

    updateResumenFinal?.();
};




window.agregarFilaMateriales = function () {
    const tabla = document.getElementById('tablaMateriales');
    const tbody = tabla.querySelector('tbody');
    const filas = tbody.querySelectorAll('tr');
    const nuevaFila = filas[filas.length - 1].cloneNode(true);

    // Calcular el nuevo índice (cantidad de filas actuales)
    const nuevoIndex = filas.length;

    // Actualizar los name e id de cada input
    nuevaFila.querySelectorAll('input').forEach(input => {
        const name = input.getAttribute('name');

        if (name) {
            // Reemplazar el índice del name con el nuevo índice
            const nuevoName = name.replace(/\[\d+\]/, `[${nuevoIndex}]`);
            input.setAttribute('name', nuevoName);
        }

        // Limpiar valores según el tipo de campo
        if (input.name.includes('[orden]')) {
            input.value = 1;
        } else if (input.name.includes('[eliminar]')) {
            input.value = 0;
        } else {
            input.value = '';
        }
    });

    // Resetear contenido de celdas calculadas
    const totalCell = nuevaFila.querySelector('.totalFila');
    if (totalCell) {
        totalCell.dataset.total = "0";
        totalCell.textContent = "$ 0,00";
    }

    const latasCell = nuevaFila.querySelector('.latas');
    if (latasCell) {
        latasCell.textContent = "—";
    }

    tbody.appendChild(nuevaFila);

    updateResumenFinal?.();
};

// ==========================
// FUNCIONES DE CÁLCULO Y ACTUALIZACIÓN
// ==========================

function actualizarJornalPorCategoria(fila) {
    const selectCategoria = fila.querySelector('.obra_categoria');
    const option = selectCategoria?.selectedOptions[0];
    const jornalTotal = option?.getAttribute('data-jornal-total');
    const inputJornal = fila.querySelector('.valor-jornal');
    const valor = parseFloat(jornalTotal);

    if (inputJornal && !isNaN(valor)) {
        inputJornal.value = valor.toFixed(2);
    } else if (inputJornal) {
        inputJornal.value = "0.00";
    }
}


window.updateResumenFinal = function (formulario) {
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
        if (input.checked && input.value !== "1") {
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
    const checkboxIVA = formulario.querySelector('.gasto-fijo[value="1"]');
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
    const actualizar = (selector, valor, sufijo = "$") => {
        const el = formulario.querySelector(`#${selector}`);
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
};
// Fin de window.updateResumenFinal



document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form.presupuesto-form').forEach(formulario => {
        updateResumenFinal(formulario);
    });

    // 🔄 Refrescar automáticamente la categoría al cargar para la primera fila
    document.querySelectorAll('.mano-obra-fila').forEach(fila => {
        const select = fila.querySelector('.obra_categoria');
        if (select) {
            const event = new Event('change');
            select.dispatchEvent(event);
        }
    });
});


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
        updateResumenFinal(e.target.closest('form'));

    }
});



// ==========================
// EVENTOS
// ==========================

form.addEventListener('input', function (e) {
    const n = e.target.name || '';
    if (
        e.target.classList.contains('obra_categoria') ||
        e.target.classList.contains('obra_cantidad') ||
        e.target.classList.contains('obra_dias') ||
        n.includes('[cantidad_unidades]') ||
        n.includes('[manos]') ||
        n.includes('[rendimiento]') ||
        n.includes('[litros_por_lata]') ||
        n.includes('[costo_unitario]') ||
        e.target.id === 'utilidad' ||
        e.target.id === 'bps_porcentaje'
    ) {
        const fila = e.target.closest('tr');
        if (e.target.classList.contains('obra_categoria')) {
            actualizarJornalPorCategoria(fila);
        }
        updateResumenFinal();
    }
});

window.eliminarFila = function (boton) {
    const fila = boton.closest('tr');
    const tabla = fila.closest('table');
    const cuerpo = tabla.querySelector('tbody');
    const totalFilas = cuerpo.querySelectorAll('tr:not([style*="display: none"])').length;

    if (totalFilas <= 1) {
        alert('Debe haber al menos una fila en esta sección.');
        return;
    }

    const inputEliminar = fila.querySelector('.eliminar-material');
    if (inputEliminar) {
        inputEliminar.value = 1;
        fila.style.display = 'none';
    }

    updateResumenFinal?.();
};

document.addEventListener('DOMContentLoaded', () => {
    updateResumenFinal();
});


</script>
