<!-- MENU -->
<nav class="navbar navbar-light" style="background-color: #ffffff;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Categorías y Clasificaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- Barra de búsqueda -->
                <input class="form-control mb-3" id="search-bar" type="text"
                    placeholder="Buscar categorías o clasificaciones..." oninput="filterCategoriesAndClassifications()">

                <h6 class="text-primary">Categorías</h6>
                <!-- Categorías -->
                @foreach($categorias as $categoria)
                    <div class="mb-3">
                        <strong>{{ $categoria->nombre_categoria }}</strong>
                        <div class="border rounded p-2 mt-1">
                            <p>{{ $categoria->descripcion_categoria }}</p>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
                                class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST">
                                    onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <hr>

                <!-- Clasificaciones -->
                @foreach($clasificaciones as $clasificacion)
                    <div class="mb-3">
                        <strong>{{ $clasificacion->nombre_clasificacion }}</strong>
                        <div class="border rounded p-2 mt-1">
                            <p>{{ $clasificacion->descripcion_clasificacion }}</p>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('clasificaciones.edit', $clasificacion) }}" class="btn btn-warning">Editar</a>
                                    class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('clasificaciones.destroy', $clasificacion) }}" method="POST">
                                    method="POST" onsubmit="return confirm('¿Eliminar esta clasificación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</nav>