<div class="row mb-4">
    <div class="col">
        <h1 class="h3 pb-2 title-custom">Agregar Nuevo Producto</h1>
    </div>
</div>

<div class="card shadow-sm border-0" style="background-color: #ffffff;">
    <div class="card-body p-4">
        <form id="item-form" autocomplete="off">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="codigo" class="form-label">Código del Producto</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="MAR-001" minlength="3" maxlength="10" pattern="[A-Z0-9-]+" title="Solo letras mayúsculas, números y guiones" required>
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre descriptivo del producto" minlength="5" maxlength="100" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="perfil" class="form-label">Categoría</label>
                    <select class="form-select" name="categoria" id="categoria" required>
                        <option value="" selected disabled>Seleccione una categoría...</option>
                        <option value="1">Herramientas Eléctricas</option>
                        <option value="2">Herramientas Manuales</option>
                        <option value="3">Materiales de Construcción</option>
                        <option value="4">Pinturería</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="precio" class="form-label">Precio ($)</label>
                    <input type="number" class="form-control" id="precio" name="precio" required min="0" step="0.01" placeholder="0.00">
                </div>
                <div class="col-md-3">
                    <label for="stock" class="form-label">Stock Inicial</label>
                    <input type="number" class="form-control" id="stock" name="stock" required min="0" step="1" placeholder="0">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción del producto</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="255" placeholder="Detalles técnicos, marca, material, etc..."></textarea>
                </div>
            </div>

            <div class="d-flex gap-2 border-top pt-3">
                <button type="submit" class="btn btn-custom-primary px-4" id="btn-guardar">Validar y guardar</button>
                <a href="<?= APP_URL ?>item" class="btn btn-custom-secondary px-4">Volver al catálogo</a>
            </div>
        </form>
        <div id="message" class="alert alert-success d-none mt-4" >
            ¡Formulario enviado correctamente!
        </div>
    </div>
</div>