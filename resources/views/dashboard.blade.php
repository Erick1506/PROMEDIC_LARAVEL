@extends('layouts.app')


@section('content')
    <h1>Listado de Productos</h1>    
    @if ($productos->isEmpty())
        <p>No hay productos registrados.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad en Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->Id_Producto }}</td> {{-- ID del producto --}}
                        <td>{{ $producto->Nombre_Producto }}</td> {{-- Nombre del producto --}}
                        <td>{{ $producto->Descripcion_Producto }}</td> {{-- Descripción del producto --}}
                        <td>{{ $producto->Precio }}</td> {{-- Precio del producto --}}
                        <td>{{ $producto->Cantidad_Stock }}</td> {{-- Cantidad de stock --}}
                        <td>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
