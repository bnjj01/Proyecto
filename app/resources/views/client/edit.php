<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center border-bottom pb-2 title-custom">
        <h1 class="h3 mb-0">Detalle y Edición del Cliente</h1>
        <div class="d-flex gap-2">
            <button type="button" id="btn-eliminar" class="btn btn-danger btn-sm">Eliminar Cliente</button>
            <a href="<?= APP_URL ?>client" class="btn btn-secondary btn-sm">Volver al listado</a>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form id="client-form" autocomplete="off">
            <input type="hidden" id="client-id" value="<?= htmlspecialchars($this->clientId ?? 0) ?>">

            <div class="row mb-4 border-bottom pb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Tipo de Cliente</label>
                    <div class="fs-5 text-dark fw-bold mb-0">
                        <?= htmlspecialchars($this->client['tipo'] ?? '') ?>
                    </div>
                    <input type="hidden" id="tipo"value="<?= htmlspecialchars($this->client['tipo'] ?? '') ?>" required>
                </div>
            </div>

            <div class="row mb-3" id="seccion-particular">
                <div class="col-md-4">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control input-particular" name="apellido" id="apellido" disabled required pattern="[A-Za-z\s-]{2,100}" value="<?= htmlspecialchars($this->client['apellido'] ?? '') ?>">
                </div>
                <div class="col-md-5">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" class="form-control input-particular" name="nombres" id="nombres" disabled required pattern="[A-Za-z\s-]{2,100}" value="<?= htmlspecialchars($this->client['nombres'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control input-particular" name="dni" id="dni" disabled required value="<?= htmlspecialchars($this->client['dni'] ?? '') ?>" pattern="[0-9]{8,9}">
                </div>
            </div>

            <div class="row mb-3 d-none" id="seccion-empresa">
                <div class="col-md-8">
                    <label for="razon_social" class="form-label">Razón Social</label>
                    <input type="text" class="form-control input-empresa" name="razon_social" id="razon_social" disabled value="<?= htmlspecialchars($this->client['razon_social'] ?? '') ?>" pattern="[A-Za-z\s-]{2,100}">
                </div>
                <div class="col-md-4">
                    <label for="cuit" class="form-label">CUIT</label>
                    <input type="text" class="form-control input-empresa" name="cuit" id="cuit" disabled required pattern="[0-9]{11}" value="<?= htmlspecialchars($this->client['cuit'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3 pt-3 border-top">
                <div class="col-md-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" id="telefono" disabled value="<?= htmlspecialchars($this->client['telefono'] ?? '') ?>" pattern="[0-9]{10}">
                </div>
                <div class="col-md-4">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo" id="correo" disabled value="<?= htmlspecialchars($this->client['correo'] ?? '') ?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                </div>
                <div class="col-md-4">
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input type="text" class="form-control" name="domicilio" id="domicilio" disabled value="<?= htmlspecialchars($this->client['domicilio'] ?? '') ?>" pattern="[A-Za-z\s-]{2,100}">
                </div>
            </div>

            <div class="d-flex gap-2 pt-3 mt-4 border-top">
                <button type="button" id="btn-editar" class="btn btn-warning px-4">Editar</button>
                <button type="button" id="btn-actualizar" class="btn btn-success px-4 d-none">Actualizar</button>
                <button type="button" id="btn-cancelar" class="btn btn-secondary px-4 d-none">Cancelar</button>
            </div>
        </form>

        <div id="message" class="alert alert-success d-none mt-4">
            ¡Cambios guardados correctamente!
        </div>
    </div>
</div>