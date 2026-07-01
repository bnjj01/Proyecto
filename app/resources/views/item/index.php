<div class="row mb-4">
    <div class="col">
        <h1 class="h2 border-bottom pb-2 title-custom">Gestión de Productos</h1>
    </div>
</div>

<div class="row mb-3">
    <div class="col d-flex gap-2">
        <a class="btn btn-custom-primary" id="btnNewItem" href="<?= APP_URL ?>item/create">Agregar Producto</a>
        <a href="<?= APP_URL ?>category" class="btn btn-custom-secondary">Administrar Categorías</a>
        <a href="<?= APP_URL ?>item/exportPdf" target="_blank" class="btn btn-custom-secondary">Exportar inventario</a>
    </div>
</div>

<div class="card mb-4 bg-light">
    <div class="card-body">
        <h5 class="card-title h6 mb-3">Filtrar Catálogo</h5>
        <form class="row g-3 align-items-end" id="item-form">
            <div class="col-md-4">
                <label for="filtroNombre" class="form-label">Buscar por Nombre o Código</label>
                <input type="text" class="form-control" name="filtroNombre" id="filtroNombre" placeholder="Ej: AAA-000">
            </div>

            <div class="col-md-3">
                <label for="filtroCategoria" class="form-label">Categoría</label>
                <select name="filtroCategoria" id="filtroCategoria" class="form-select">
                    <option value="" selected>Todos...</option>
                    <option value="1">Herramientas Eléctricas</option>
                    <option value="2">Herramientas Manuales</option>
                    <option value="3">Materiales de Construcción</option>
                    <option value="4">Pinturería</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark w-100">Aplicar Filtros</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle border" id="tabla-items">
        <thead class="user-table">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>