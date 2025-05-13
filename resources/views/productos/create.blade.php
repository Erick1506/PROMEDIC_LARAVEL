@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Agregar Producto</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Este formulario llama al método store --}}
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            {{-- Aquí se incluye el fragmento común del formulario --}}
            @include('productos.form')

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const clasificaciones = @json($clasificaciones);

    document.addEventListener('DOMContentLoaded', () => {
        const categoriaSelect = document.getElementById('categoria');
        const clasificacionSelect = document.getElementById('clasificacion');

        function actualizarClasificaciones() {
            const idCategoria = categoriaSelect.value;
            clasificacionSelect.innerHTML = '<option value="">Seleccione una clasificación</option>';

            clasificaciones.forEach(clasificacion => {
                if (clasificacion.Id_Categoria == idCategoria) {
                    const option = document.createElement('option');
                    option.value = clasificacion.Id_Clasificacion;
                    option.textContent = clasificacion.Nombre_Clasificacion;
                    clasificacionSelect.appendChild(option);
                }
            });
        }

        categoriaSelect.addEventListener('change', actualizarClasificaciones);

        // Si hay un valor seleccionado al cargar
        if (categoriaSelect.value) {
            actualizarClasificaciones();
        }
    });
</script>
@endpush

