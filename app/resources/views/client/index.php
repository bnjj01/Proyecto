<div class="row mb-4">
    <div class="col">
        <h1 class="h2 border-bottom pb-2 title-custom">Gestión de Clientes</h1>
    </div>
</div>

<div class="row mb-3">
    <div class="col d-flex gap-2">
        <a href="<?= APP_URL ?>client/create" class="btn btn-custom-primary">Registrar Nuevo Cliente</a>
    </div>
</div>

<div class="card mb-4 bg-light">
    <div class="card-body">
        <form class="row g-3 align-items-end" id="form-filtros-cliente">
            <div class="col-md-5">
                <label for="filtroBusqueda" class="form-label">Buscar por Nombre, Razón Social, DNI o CUIT</label>
                <input type="text" name="filtroBusqueda" class="form-control" id="filtroBusqueda" placeholder="Ej: Juan Perez o 20334445551">
            </div>
            
            <div class="col-md-3">
                <label for="filtroTipo" class="form-label">Tipo de Cliente</label>
                <select name="filtroTipo" id="filtroTipo" class="form-select">
                    <option value="" selected>Todos...</option>
                    <option value="Particular">Particular</option>
                    <option value="Empresa">Empresa</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark w-100">Buscar</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table id="tabla-clientes" class="table table-striped table-hover align-middle border">
        <thead class="table-dark">
            <tr>
                <th>Tipo</th>
                <th>Nombre / Razón Social</th>
                <th>Documento (DNI/CUIT)</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            </tbody>
    </table>
</div>