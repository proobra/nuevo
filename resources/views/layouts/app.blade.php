<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Proobra Intranet')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Estilos Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Ajuste para evitar que el contenido quede escondido debajo de la barra --}}
  <style>
    body {
      padding-top: 70px;
    }
  </style>
</head>
<body>

  {{-- BARRA DE NAVEGACIÓN SUPERIOR --}}
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top px-3" style="background-color: rgb(240, 158, 7);">

    <a class="navbar-brand" href="{{ url('/') }}">Proobra</a>


   {{-- botón hamburguesa de Bootstrap para mostrar u ocultar el menú en pantallas chicas  --}}
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Mostrar navegación">
      <span class="navbar-toggler-icon"></span>
    </button>
   
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('presupuestos') || request()->is('presupuestos/*') ? 'active-custom' : '' }}" 
           href="{{ route('presupuestos.index') }}">
          📋 Ver presupuestos
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('configuraciones') ? 'active-custom' : '' }}" 
           href="{{ url('/configuraciones') }}">
          ⚙️ Configuraciones
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('configuracion/laudos') ? 'active-custom' : '' }}" 
           href="{{ route('laudos.index') }}">
          💼 Laudos de Operarios
        </a>
      </li>
    </ul>

    {{--Formulario de busqueda por id direccion etc--}}
    <form class="d-flex ms-3" method="GET" action="{{ route('presupuestos.buscar') }}">
      <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Buscar presupuesto..." aria-label="Buscar">
      <button class="btn btn-outline-light btn-sm" type="submit">🔍</button>
    </form>
    



    <!-- BOTON 2 En cualquier lugar de tu sistema -->
<form action="{{ route('presupuestos.store') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn btn-primary">+ Crear nuevo presupuesto</button>
</form>


   {{-- boton 1 crear nuevo ppto sobre barra navegacion 
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('presupuestos.index') }}">Presupuestos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('presupuestos.create') }}">+ Nuevo presupuesto</a>
        </li>
      </ul>
      --}}

      {{-- Botón de logout --}}
      <form class="d-flex" method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline-light btn-sm" type="submit">Cerrar sesión</button>
      </form>
    </div>
  </nav>

  {{-- CONTENIDO DE LA VISTA --}}
  <main class="container">
    @yield('content')
  </main>

  {{-- JS Bootstrap --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  @stack('scripts')
</body>
</html>

