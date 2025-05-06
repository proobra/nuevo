<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Jornal</th>
            <th>Activo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categorias as $cat)
        <tr>
            <td>{{ $cat->nombre }}</td>
            <td>${{ number_format($cat->jornal, 2) }}</td>
            <td>{{ $cat->activo ? 'Sí' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
