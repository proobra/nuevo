<form action="{{ route('presupuestos.store') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="text-green-700 font-semibold hover:underline">
        ➕ Crear nuevo presupuesto
    </button>
</form>


<x-nav-link :href="route('presupuestos.index')" :active="request()->routeIs('presupuestos.index')">
    📋 Ver presupuestos
</x-nav-link>
