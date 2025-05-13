@extends('layouts.app')


@section('content')
    <h1>Listado de Productos</h1>    

    @if ($productos->isEmpty())
        <p>No hay productos registrados.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Código de Barras</th>
                    <th>Marca</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $categoriaAnterior = null;
                    $clasificacionAnterior = null;
                @endphp

                {{-- Productos disponibles --}}
                @foreach($productos->where('estadoProducto.Tipo_Estado_Producto', '!=', 'No Disponible') as $producto)
                    @php
                        $categoriaActual = $producto->clasificacion->categoria->Nombre_Categoria;
                        $clasificacionActual = $producto->clasificacion->Nombre_Clasificacion;
                    @endphp

                    @if ($categoriaActual !== $categoriaAnterior)
                        <tr class="table-primary">
                            <td colspan="11"><strong>Categoría:</strong> {{ $categoriaActual }}</td>
                        </tr>
                        @php
                            $categoriaAnterior = $categoriaActual;
                            $clasificacionAnterior = null;
                        @endphp
                    @endif

                    @if ($clasificacionActual !== $clasificacionAnterior)
                        <tr class="table-secondary">
                            <td colspan="11"><strong>Clasificación:</strong> {{ $clasificacionActual }}</td>
                        </tr>
                        @php $clasificacionAnterior = $clasificacionActual; @endphp
                    @endif

                    <tr>
                        <td>{{ $producto->Id_Producto }}</td>
                        <td>{{ $producto->Nombre_Producto }}</td>
                        <td>{{ $producto->Descripcion_Producto }}</td>
                        <td>{{ $producto->Precio }} COP</td>
                        <td>{{ $producto->Cantidad_Stock }}</td>
                        <td>{{ $producto->Unidad }}</td>
                        <td>{{ $producto->Fecha_Vencimiento }}</td>
                        <td>{{ $producto->Codigo_Barras }}</td>
                        <td>{{ $producto->marca->Marca_Producto ?? 'Sin marca' }}</td>
                        <td>{{ $producto->estadoProducto->Tipo_Estado_Producto ?? 'Sin estado' }}</td>
                        <td>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-light">Editar</a>
                        </td>
                    </tr>
                @endforeach

                {{-- Productos NO disponibles --}}
                @php
                    $categoriaAnterior = null;
                    $clasificacionAnterior = null;
                @endphp

                @if ($productos->where('estadoProducto.Tipo_Estado_Producto', 'No Disponible')->isNotEmpty())
                    <tr class="table-danger">
                        <td colspan="11"><strong>Productos No Disponibles</strong></td>
                    </tr>
                @endif

                @foreach($productos->where('estadoProducto.Tipo_Estado_Producto', 'No Disponible') as $producto)
                    @php
                        $categoriaActual = $producto->clasificacion->categoria->Nombre_Categoria;
                        $clasificacionActual = $producto->clasificacion->Nombre_Clasificacion;
                    @endphp

                    @if ($categoriaActual !== $categoriaAnterior)
                        <tr class="table-primary">
                            <td colspan="11"><strong>Categoría:</strong> {{ $categoriaActual }}</td>
                        </tr>
                        @php
                            $categoriaAnterior = $categoriaActual;
                            $clasificacionAnterior = null;
                        @endphp
                    @endif

                    @if ($clasificacionActual !== $clasificacionAnterior)
                        <tr class="table-secondary">
                            <td colspan="11"><strong>Clasificación:</strong> {{ $clasificacionActual }}</td>
                        </tr>
                        @php $clasificacionAnterior = $clasificacionActual; @endphp
                    @endif

                    <tr>
                        <td>{{ $producto->Id_Producto }}</td>
                        <td>{{ $producto->Nombre_Producto }}</td>
                        <td>{{ $producto->Descripcion_Producto }}</td>
                        <td>{{ $producto->Precio }} COP</td>
                        <td>{{ $producto->Cantidad_Stock }}</td>
                        <td>{{ $producto->Unidad }}</td>
                        <td>{{ $producto->Fecha_Vencimiento }}</td>
                        <td>{{ $producto->Codigo_Barras }}</td>
                        <td>{{ $producto->marca->Marca_Producto ?? 'Sin marca' }}</td>
                        <td>{{ $producto->estadoProducto->Tipo_Estado_Producto ?? 'Sin estado' }}</td>
                        <td>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-light">Editar</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif
@endsection
