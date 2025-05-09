{{-- resources/views/configuracion/partials/gastos-fijos.blade.php --}}
<div class="space-y-4">

    {{-- Tabla de gastos fijos configurables --}}
    <table class="w-full text-sm text-left border rounded shadow">
        <thead class="bg-gray-100 text-gray-700 uppercase">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Tipo</th>
                <th class="px-4 py-2">Valor</th>
                <th class="px-4 py-2">Unidad</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gastosFijos as $gasto)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $gasto->nombre }}</td>
                    <td class="px-4 py-2">{{ ucfirst($gasto->tipo) }}</td>
                    <td class="px-4 py-2">{{ $gasto->valor }}</td>
                    <td class="px-4 py-2">{{ $gasto->unidad }}</td>
                    <td class="px-4 py-2">
                        {{-- En el futuro se puede implementar edición inline o modal --}}
                        <form action="{{ route('configuracion.gastos_fijos.guardar') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $gasto->id }}">
                            <button class="text-blue-600 hover:underline">Editar</button>
                        </form>
                        <form action="{{ route('configuracion.gastos_fijos.eliminar', $gasto->id) }}" method="POST" class="inline ml-2">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Formulario para agregar nuevo gasto fijo --}}
    <form action="{{ route('configuracion.gastos_fijos.guardar') }}" method="POST" class="mt-4 p-4 border rounded bg-gray-50">
        @csrf
        <h3 class="font-semibold text-lg mb-2">➕ Agregar nuevo gasto fijo</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded p-1" required>
            </div>
            <div>
                <label class="block text-sm">Tipo</label>
                <select name="tipo" class="w-full border rounded p-1" required>
                    <option value="porcentaje">Porcentaje (%)</option>
                    <option value="fijo">Fijo ($)</option>
                    <option value="constante">Constante (x)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm">Valor</label>
                <input type="number" step="0.01" name="valor" class="w-full border rounded p-1" required>
            </div>
            <div>
                <label class="block text-sm">Unidad</label>
                <input type="text" name="unidad" class="w-full border rounded p-1" placeholder="%, $, x">
            </div>
        </div>
        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
    </form>
</div>
