<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center border-bottom pb-2 title-custom">
        <h1 class="h3 mb-0">Detalle y Edición de Cuenta</h1>
        
        <div class="d-flex gap-2">
            <a href="#" class="btn btn-danger btn-sm" id="btn-eliminar">Eliminar registro</a>
            <a href="#" class="btn btn-secondary btn-sm">Exportar a PDF</a>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0" style="background-color: #ffffff;">
    <div class="card-body p-4">
        <div class="detalle-cuenta alert alert-info d-flex justify-content-around mb-4">
            <span><strong>Estado de la cuenta:</strong> Activa</span>
            <span><strong>Fecha de creación:</strong> 15/03/2026</span>
        </div>

        <form id="user-form" action="#" method="POST" autocomplete="off">
            <input type="hidden" id="user-id" name="id" value="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" id="apellido" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" name="nombres" class="form-control" id="nombres" disabled required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cuenta" class="form-label">Cuenta</label>
                    <input type="text" name="cuenta" class="form-control" id="cuenta" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="perfil" class="form-label">Perfil</label>
                    <select class="form-select" name="perfil" id="perfil" disabled required>
                        <option value="Operador">Operador</option>
                        <option value="Administrador" selected>Administrador</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control" id="correo" disabled required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="clave" class="form-label">Clave</label>
                    <input type="password" name="clave" class="form-control" id="clave" disabled>
                </div>
                <div class="col-md-6">
                    <label for="confirmarClave" class="form-label">Confirmación de la clave</label>
                    <input type="password" name="confirmarClave" class="form-control" id="confirmarClave" disabled>
                </div>
            </div>

            <div class="d-flex gap-2 border-top pt-3">
                <button type="button" class="btn btn-warning px-4" id="btn-editar">Editar</button>

                <button type="button" class="btn btn-success px-4 d-none" id="btn-actualizar">Actualizar</button>
                
                <button type="button" class="btn btn-secondary px-4 d-none" id="btn-cancelar">Cancelar</button>
                
                <a href="<?= APP_URL ?>user" class="btn btn-custom-secondary px-4 ms-auto">Volver al listado</a>
            </div>
        </form>
    </div>
</div>