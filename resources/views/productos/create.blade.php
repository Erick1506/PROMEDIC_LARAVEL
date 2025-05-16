@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/assets/css/producto.create.css') }}">
@endsection

@section('content')
    <fieldset class="border p-4 rounded shadow-sm bg-light">
        <legend class="text-primary text-center mb-4">Agregar Producto</legend>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        {{-- Incluir aquí el formulario reutilizable --}}
        @include('productos.form')
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const clasificaciones = @json($clasificaciones);

    document.addEventListener('DOMContentLoaded', () => {
        const categoriaSelect = document.querySelector('select[name="Id_Categoria"]');
        const clasificacionSelect = document.querySelector('select[name="Id_Clasificacion"]');

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

        if (categoriaSelect.value) {
            actualizarClasificaciones();
        }
    });
</script>
@endpush
