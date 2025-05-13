<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
      <h2 class="m-0">Promedic</h2>
    </a>
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menú colapsable --}}
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
             href="{{ route('dashboard') }}">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('estadisticas.*') ? 'active' : '' }}"
             href="{{ route('estadisticas.index') }}">Estadísticas</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('productos*') ? 'active' : '' }}"
             href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Productos
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="{{ route('promociones.index') }}">
                Promociones
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('productos.create') }}">
                Agregar Producto
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('recetas*') ? 'active' : '' }}"
             href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Fórmulas médicas
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="{{ route('recetas.index') }}">
                Fórmulas registradas
              </a>
            </li>
          </ul>
        </li>
      </ul>

      {{-- Sección derecha: notificaciones, búsqueda, perfil --}}
      <div class="d-flex align-items-center">
        <!-- Notificaciones -->
        <button type="button"
                class="btn btn-outline-primary position-relative me-3"
                data-bs-toggle="modal"
                data-bs-target="#notificationsModal"
                style="width:2.5rem; height:2.5rem;">
          <i class="bi bi-bell fs-5"></i>
          <span id="notificationCount"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="display:none; width:1.2rem; height:1.2rem; font-size:.75rem;">
            0
          </span>
        </button>

        <!-- Búsqueda -->
        <button class="btn btn-outline-secondary me-3"
                data-bs-toggle="modal"
                data-bs-target="#searchModal"
                style="width:2.5rem; height:2.5rem;">
          <i class="bi bi-search fs-5"></i>
        </button>

        <!-- Perfil -->
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle"
                  type="button"
                  id="dropdownProfileButton"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
            <i class="bi bi-person fs-5"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfileButton">
            <li>
              <a class="dropdown-item"
                 href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
            <li><a class="dropdown-item" href="{{ route('regente.index') }}">Gestión de regente</a></li>
            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}">Gestión de proveedor</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>

{{-- Modal de notificaciones --}}
<div class="modal fade" id="notificationsModal" tabindex="-1"
     aria-labelledby="notificationsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationsModalLabel">Notificaciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="notificationBody">
        <p>Cargando notificaciones...</p>
      </div>
      <div class="modal-footer">
        <input type="text" id="newNotification" class="form-control" placeholder="Escribe una notificación">
        <button type="button" class="btn btn-primary" id="addNotification">Agregar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-tercero" id="goToDetailsBtn">Ir a detalles</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal de búsqueda --}}
<div class="modal fade" id="searchModal" tabindex="-1"
     aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">Buscar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="searchForm" action="{{ route('productos.index') }}" method="GET">
          <div class="input-group">
            <input type="text" name="q" id="productName"
                   class="form-control" placeholder="Ingrese el nombre del producto">
            <button class="btn btn-primary" type="submit" id="searchProduct">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
