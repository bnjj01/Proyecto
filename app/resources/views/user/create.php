<div class="row mb-4">
    <div class="col">
        <h1 class="h3 pb-2 title-custom">Alta de nueva cuenta</h1>
    </div>
</div>

<div class="card shadow-sm border-0" style="background-color: #ffffff;">
    <div class="card-body p-4">
        <form id="user-form" autocomplete="off">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="apellido" id="apellido" required>
                </div>
                <div class="col-md-6">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" class="form-control" name="nombres" id="nombres" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cuenta" class="form-label">Cuenta (Nombre de usuario)</label>
                    <input type="text" class="form-control" name="cuenta" id="cuenta" required>
                </div>
                <div class="col-md-6">
                    <label for="perfil" class="form-label">Perfil</label>
                    <select class="form-select" name="perfil" id="perfil" required>
                        <option value="" selected disabled>Seleccione un perfil...</option>
                        <option value="Operador">Operador</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="correo" id="correo" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="clave" class="form-label">Clave</label>
                    <input type="password" class="form-control" name="clave" id="clave" required>
                </div>
                <div class="col-md-6">
                    <label for="confirmarClave" class="form-label">Confirmación de la clave</label>
                    <input type="password" class="form-control" name="confirmarClave" id="confirmarClave" required>
                </div>
            </div>

            <div class="d-flex gap-2 border-top pt-3">
                <button type="submit" class="btn btn-custom-primary px-4" id="btn-guardar">Validar y guardar</button>
                <a href="<?= APP_URL ?>user" class="btn btn-custom-secondary px-4">Volver al listado</a>
            </div>
        </form>
        <div id="message" class="alert alert-success d-none mt-4" role="alert" >
            ¡Formulario enviado correctamente!
        </div>
    </div>
</div>