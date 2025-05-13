<div class="form-group">
    <label for="Precio">Precio *</label>
    <input type="number" step="0.01" name="Precio" class="form-control"
        value="{{ old('Precio', $producto->Precio ?? '') }}" required>
</div>

<div class="form-group">
    <label for="Costo_Adquisicion">Costo de Adquisición *</label>
    <input type="number" step="0.01" name="Costo_Adquisicion" class="form-control"
        value="{{ old('Costo_Adquisicion', $producto->Costo_Adquisicion ?? '') }}" required>
</div>

<div class="form-group">
    <label for="Peso">Peso *</label>
    <input type="text" name="Peso" class="form-control" value="{{ old('Peso', $producto->Peso ?? '') }}" required>
</div>

<div class="form-group">
    <label for="Id_Marca">Marca *</label>
    <select name="Id_Marca" class="form-control" required>
        <option value="">Seleccione una marca</option>
        @foreach ($marcas as $marca)
            <option value="{{ $marca->Id_Marca }}" {{ old('Id_Marca', $producto->Id_Marca ?? '') == $marca->Id_Marca ? 'selected' : '' }}>
                {{ $marca->Nombre_Marca }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="Id_Estado_Producto">Estado del Producto *</label>
    <select name="Id_Estado_Producto" class="form-control" required>
        <option value="">Seleccione un estado</option>
        @foreach ($estados as $estado)
            <option value="{{ $estado->Id_Estado_Producto }}" {{ old('Id_Estado_Producto', $producto->Id_Estado_Producto ?? '') == $estado->Id_Estado_Producto ? 'selected' : '' }}>
                {{ $estado->Nombre_Estado }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="Id_Categoria">Categoría *</label>
    <select name="Id_Categoria" class="form-control" required>
        <option value="">Seleccione una categoría</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->Id_Categoria }}" {{ old('Id_Categoria', $producto->Id_Categoria ?? '') == $categoria->Id_Categoria ? 'selected' : '' }}>
                {{ $categoria->Nombre_Categoria }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="Id_Clasificacion">Clasificación *</label>
    <select name="Id_Clasificacion" class="form-control" required>
        <option value="">Seleccione una clasificación</option>
        @foreach ($clasificaciones as $clasificacion)
            <option value="{{ $clasificacion->Id_Clasificacion }}" {{ old('Id_Clasificacion', $producto->Id_Clasificacion ?? '') == $clasificacion->Id_Clasificacion ? 'selected' : '' }}>
                {{ $clasificacion->Nombre_Clasificacion }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="Id_Fecha_Vencimiento">Fecha de Vencimiento *</label>
    <select name="Id_Fecha_Vencimiento" class="form-control" required>
        <option value="">Seleccione una fecha</option>
        @foreach ($fechas_vencimiento as $fecha)
            <option value="{{ $fecha->Id_Fecha_Vencimiento }}" {{ old('Id_Fecha_Vencimiento', $producto->Id_Fecha_Vencimiento ?? '') == $fecha->Id_Fecha_Vencimiento ? 'selected' : '' }}>
                {{ $fecha->Fecha }}
            </option>
        @endforeach
    </select>
</div>