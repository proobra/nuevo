<script>
  const formatoUYU = new Intl.NumberFormat('es-UY', { style: 'currency', currency: 'UYU' });

  let indexMaterial = document.querySelectorAll('#tablaMateriales tbody tr').length || 1;

  function agregarFilaReplanteo() {
    const tabla = document.querySelector('#tabla-replanteo tbody');
    const id = tabla.querySelectorAll('tr').length + 1;
    const fila = document.createElement('tr');
    fila.innerHTML = `
      <td><input class="form-control id-replanteo" name="replanteo_id[]" readonly style="width:60px;" type="text" value="${id}"/></td>
      <td><input class="form-control" name="replanteo_descripcion[]" type="text"/></td>
      <td><input class="form-control" name="replanteo_metros2[]" type="number" oninput="updateResumenFinal()"/></td>
      <td><input class="form-control" name="replanteo_dias[]" type="number" oninput="updateResumenFinal()"/></td>
      <td><input class="form-control" name="replanteo_observaciones[]" type="text"/></td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">🗑️</button></td>
    `;
    tabla.appendChild(fila);
  }

  // Funciones que deben quedar globales
  window.agregarFilaReplanteo = agregarFilaReplanteo;
  window.agregarFilaManoDeObra = agregarFilaManoDeObra;
  window.agregarFilaMateriales = agregarFilaMateriales;
  window.eliminarFila = eliminarFila;
  window.updateResumenFinal = updateResumenFinal; // ✅ Aquí la función buena

  document.addEventListener('DOMContentLoaded', () => {
    calcularManoDeObra();
    calcularMateriales();
    updateResumenFinal(); // ✅ Llamamos a la nueva función
  });
</script>
