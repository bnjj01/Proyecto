<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center border-bottom pb-2 title-custom">
        <h1 class="h3 mb-0">Detalle y Edición del Producto</h1>
        
        <div class="d-flex gap-2">
            <button type="button" id="btn-eliminar" class="btn btn-danger btn-sm">Eliminar Producto</button>
            <a href="<?= APP_URL ?>item/exportPdf/<?= $this->itemId ?>" target="_blank" class="btn btn-secondary btn-sm">Exportar a PDF</a>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0" style="background-color: #ffffff;">
    <div class="card-body p-4">
        <div class="detalle-cuenta alert alert-info d-flex justify-content-around mb-4">
            <span><strong>Estado:</strong> Activo (En Venta)</span>
            <span><strong>Ultima Actualización de Stock:</strong> 10/04/2026</span>
        </div>

        <form id="item-form" action="#" method="POST" autocomplete="off">
            <input type="hidden" id="item-id" value="<?= $this->itemId ?>">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="codigo" class="form-label">Código del Producto</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" disabled required >
                </div>
                <div class="col-md-8">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" disabled required minlength="5">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" name="categoria" id="categoria" disabled required>
                        <option value="" selected disabled>Cargando categorías...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="precio" class="form-label">Precio ($)</label>
                    <input type="number" class="form-control" name="precio" id="precio" disabled required min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" id="stock" disabled required min="0">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3" disabled></textarea>
                </div>
            </div>

            <div class="d-flex gap-2 border-top pt-3">
                <button type="button" class="btn btn-warning px-4" id="btn-editar">Editar</button>
                <button type="button" class="btn btn-success px-4 d-none" id="btn-actualizar">Actualizar</button>
                <button type="button" class="btn btn-secondary px-4 d-none" id="btn-cancelar">Cancelar</button>
                <a href="<?= APP_URL ?>item" class="btn btn-custom-secondary px-4 ms-auto">Volver al listado</a>
            </div>
        </form>
    </div>
</div>