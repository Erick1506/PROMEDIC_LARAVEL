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
    
        //tipo de promocion 
        document.addEventListener('DOMContentLoaded', function () {
            // Referencias a los elementos del DOM
            const estadoProductoSelect = document.getElementById('estadoProducto');
            const formPromocion = document.getElementById('formPromocion');
            const tipoPromocionSelect = document.getElementById('tipoPromocion');
            const descuentoField = document.getElementById('descuentoField');

            // Función para cargar los tipos de promoción
            function cargarPromociones() {
                fetch('Obtener_Datos.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Error HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Verifica si hay errores
                        if (data.errores.length > 0) {
                            console.error('Errores encontrados:', data.errores);
                            tipoPromocionSelect.innerHTML = '<option value="">Error al cargar datos</option>';
                            return;
                        }

                        // Limpia el <select> y agrega las promociones
                        tipoPromocionSelect.innerHTML = '';
                        if (data.promociones.length > 0) {
                            data.promociones.forEach(promocion => {
                                const option = document.createElement('option');
                                option.value = promocion.Id_Tipo_Promocion;
                                option.textContent = promocion.Tipo_Promocion;
                                tipoPromocionSelect.appendChild(option);
                            });
                        } else {
                            tipoPromocionSelect.innerHTML = '<option value="">No hay tipos de promoción disponibles</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar datos:', error);
                        tipoPromocionSelect.innerHTML = '<option value="">Error al cargar datos</option>';
                    });
            }

            // Mostrar el formulario de promoción cuando el estado es "3 (Promoción)"
            estadoProductoSelect.addEventListener('change', function () {
                if (this.value === '3') { // Suponiendo que '3' es el ID de promoción
                    formPromocion.style.display = 'block';
                    cargarPromociones(); // Cargar los tipos de promoción
                } else {
                    formPromocion.style.display = 'none';
                    descuentoField.style.display = 'none'; // Ocultar el campo de descuento
                }
            });

            // Mostrar el campo de descuento si el tipo de promoción es "2 (Descuento)"
            tipoPromocionSelect.addEventListener('change', function () {
                if (this.value === '2') { // Suponiendo que '2' es el ID de descuento
                    descuentoField.style.display = 'block';
                } else {
                    descuentoField.style.display = 'none';
                }
            });
        });
</script>
@endpush
