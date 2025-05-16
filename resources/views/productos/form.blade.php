<fieldset>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="Nombre_Producto" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Descripción</label>
                <input type="text" name="Descripcion_Producto" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Precio</label>
                <input type="number" name="Precio" class="form-control" step="0.01" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cantidad</label>
                <input type="number" name="Cantidad_Stock" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Cantidad Mínima</label>
                <input type="number" name="Cantidad_Minima" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cantidad Máxima</label>
                <input type="number" name="Cantidad_Maxima" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Costo de Adquisición</label>
                <input type="number" name="Costo_Adquisicion" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Peso</label>
                <input type="text" name="Peso" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Fecha de Vencimiento</label>
                <input type="date" name="Fecha_Vencimiento" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Código de Barras</label>
                <input type="text" name="Codigo_Barras" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Marca</label>
                <select class="form-select" name="Id_Marca">
                    @forelse($marcas as $marca)
                        <option value="{{ $marca->Id_Marca }}">{{ $marca->Marca_Producto }}</option>
                    @empty
                        <option value="">No hay marcas disponibles</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Estado del Producto</label>
                <select class="form-select" name="Id_Estado_Producto">
                    @forelse($estados as $estado)
                        <option value="{{ $estado->Id_Estado_Producto }}">{{ $estado->Tipo_Estado_Producto }}</option>
                    @empty
                        <option value="">No hay estados disponibles</option>
                    @endforelse
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Categoría</label>
                <select class="form-select" name="Id_Categoria" id="categoria">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->Id_Categoria }}">{{ $categoria->Nombre_Categoria }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Clasificación</label>
                <select class="form-select" name="Id_Clasificacion" id="clasificacion">
                    <option value="">Seleccione una clasificación</option>
                      @foreach($clasificaciones as $clasificacion)
                        <option value="{{ $clasificacion->Id_Clasificacion }}">{{ $clasificacion->Nombre_Clasificacion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Proveedor</label>
                <select class="form-select" name="Id_Proveedor" id="proveedor">
                    <option value="">Seleccione un Proveedor</option>
                      @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->Id_Proveedor }}">{{ $proveedor->Nombre_Proveedor }}</option>
                    @endforeach
                </select>
                </div>
        </div>
    </fieldset>