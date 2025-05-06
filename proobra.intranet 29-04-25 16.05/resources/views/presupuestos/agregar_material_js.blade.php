
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.form-agregar-material').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');
        const data = form.serialize();
        const container = form.closest('.materiales-container');
        $.post(url, data, function (response) {
            container.find('.lista-materiales').append(response.nuevaFilaHtml);
        }).fail(function () {
            alert('Ocurrió un error al agregar la fila.');
        });
    });
});
</script>
