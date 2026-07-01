<div class="row mb-4">
    <div class="col">
        <h1 class="h2 border-bottom pb-2 title-custom">Gestión de Ventas</h1>
    </div>
</div>

<div class="row mb-3">
    <div class="col d-flex gap-2">
        <a href="<?= APP_URL ?>sale/create" class="btn btn-custom-primary">Registrar Nueva Venta</a>
        <a href="<?= APP_URL ?>sale/exportPdf" target="_blank" class="btn btn-custom-secondary" id="btn-exportar">Exportar listado</a>
    </div>
</div>

<div class="card mb-4 bg-light">
    <div class="card-body">
        <form class="row g-3 align-items-end" id="form-filtros-ventas">
            <div class="col-md-4">
                <label for="filtroCliente" class="form-label">Cliente o N° Venta</label>
                <input type="text" name="filtroCliente" class="form-control" id="filtroCliente" placeholder="Ej: Juan Perez">
            </div>
            
            <div class="col-md-3">
                <label for="fecha_inicio" class="form-label">Desde Fecha</label>
                <input type="date" name="fecha_inicio" class="form-control" id="fecha_inicio">
            </div>
            <div class="col-md-3">
                <label for="fecha_fin" class="form-label">Hasta Fecha</label>
                <input type="date" name="fecha_fin" class="form-control" id="fecha_fin">
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark w-100">Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table id="tabla-ventas" class="table table-striped table-hover align-middle border">
        <thead class="table-dark">
            <tr>
                <th>N° Venta</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Forma de Pago</th>
                <th>Total</th>
                <th>Estado</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            </tbody>
    </table>
</div>