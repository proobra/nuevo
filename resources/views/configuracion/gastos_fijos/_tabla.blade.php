<a href="{{ route('configuracion.gastos-fijos.create') }}" class="btn btn-primary mb-3">Agregar nuevo gasto</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Valor</th>
            <th>Tipo</th>
            <th>Editable</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gastos as $gasto)
        <tr>
            <td>{{ $gasto->nombre }}</td>
            <td>${{ number_format($gasto->valor, 2) }}</td>
            <td>{{ ucfirst($gasto->tipo) }}</td>
            <td>{{ $gasto->editable ? 'Sí' : 'No' }}</td>
            <td>
                <a href="{{ route('configuracion.gastos-fijos.edit', $gasto) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('configuracion.gastos-fijos.destroy', $gasto) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este gasto fijo?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
