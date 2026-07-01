<div class="row mb-4">
    <div class="col">
        <h1 class="h2 border-bottom pb-2 title-custom">Mi Perfil</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-4">Datos de la cuenta</h5>

                <dl class="row">
                    <dt class="col-sm-4">Apellido y nombres</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars(($this->profile['apellido'] ?? '') . ' ' . ($this->profile['nombres'] ?? '')) ?></dd>

                    <dt class="col-sm-4">Cuenta</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($this->profile['cuenta'] ?? '') ?></dd>

                    <dt class="col-sm-4">Correo</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($this->profile['correo'] ?? '') ?></dd>

                    <dt class="col-sm-4">Perfil</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($this->profile['perfil'] ?? '') ?></dd>

                    <dt class="col-sm-4">Fecha de alta</dt>
                    <dd class="col-sm-8"><?= htmlspecialchars($this->profile['fechaAlta'] ?? '') ?></dd>
                </dl>

                <hr>

                <h5 class="card-title mb-4">Cambiar contraseña</h5>
                <form id="form-change-password" action="<?= APP_URL ?>profile/changePassword" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="clave" class="form-label"  >Nueva contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" autocomplete="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmarClave" class="form-label" >Repetir contraseña</label>
                        <input type="password" class="form-control" id="confirmarClave" name="confirmarClave" autocomplete="new-password" required>
                    </div>
                    <button type="submit" class="btn btn-custom-primary">Actualizar contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>