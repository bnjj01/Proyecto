<div class="row mb-4">
    <div class="col">
        <h1 class="h2 border-bottom pb-2 title-custom">Gestión de Usuarios</h1>
    </div>
</div>

<div class="row mb-3">
    <div class="col d-flex gap-2">
        <a href="<?= APP_URL ?>user/create" class="btn btn-custom-primary">Alta de una nueva cuenta</a>
        <a href="<?= APP_URL ?>user/exportPdf" target="_blank" class="btn btn-custom-secondary" id="btn-exportar">Exportar listado</a>
    </div>
</div>

<div class="card mb-4 bg-light">
    <div class="card-body">
        <h5 class="card-title h6 mb-3">Filtrar resultados</h5>
        <form class="row g-3 align-items-end" id="form-filtros-usuario">
            <div class="col-md-4">
                <label for="filtroNombre" class="form-label">Buscar por Usuario / Cuenta</label>
                <input type="text" name="filtroNombre" class="form-control" id="filtroNombre" placeholder="Ej: Orlando, Matias">
            </div>

            <div class="col-md-3">
                <label for="filtroPerfil" class="form-label">Perfil</label>
                <select id="filtroPerfil" name="filtroPerfil" class="form-select">
                    <option value="" selected>Todos...</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Operador">Operador</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark w-100">Aplicar Filtros</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table id="table-user" class="table table-striped table-hover align-middle border">
        <thead class="user-table">
            <tr>
                <th>Usuario</th>
                <th>Cuenta</th>
                <th>Perfil</th>
                <th>Correo</th>
                <th class="text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>