<!-- resources/views/promociones/form.blade.php -->

<fieldset>
    <div class="container">
        <h2>Crear nueva promoción</h2>
        <div class="row mb-3">
            <label class="form-label">Categoría</label>
            <select class="form-select" name="Id_Categoria" id="categoria">
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->Id_Categoria }}">{{ $categoria->Nombre_Categoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="row mb-3">
            <label class="form-label">Clasificación</label>
            <select class="form-select" name="Id_Clasificacion" id="clasificacion">
                <option value="">Seleccione una clasificación</option>
                @foreach($clasificaciones as $clasificacion)
                    <option value="{{ $clasificacion->Id_Clasificacion }}">{{ $clasificacion->Nombre_Clasificacion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Producto</label>
            <select class="form-select" name="Id_Producto" id="producto">
                <option value="">Seleccione un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->Id_Producto }}">{{ $producto->Nombre_Producto }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipo de Promoción</label>
            <select name="tipo_promocion" id="tipo_promocion" class="form-select" onchange="actualizarDescuento()"
                required>
                <option value="">Seleccione...</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->Id_Tipo_Promocion }}">{{ $tipo->Tipo_Promocion }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="campo_descuento" style="display: none;">
            <label>Descuento (%)</label>
            <input type="number" name="descuento" id="descuento" class="form-control" min="0" max="100">
        </div>

        <div class="mb-3">
            <label>Fecha Inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Fecha Fin</label>
            <input type="date" name="fecha_fin" class="form-control" required>
        </div>

    </div>
</fieldset>