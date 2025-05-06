<table class="table table-bordered">
    <thead>
        <tr>
            <th>Clave</th>
            <th>Valor</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($constantes as $const)
        <tr>
            <td>{{ $const->clave }}</td>
            <td>{{ $const->valor }}</td>
            <td>{{ $const->descripcion }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
