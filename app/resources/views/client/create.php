<div class="row mb-4">
    <div class="col"><h1 class="h3 pb-2 title-custom">Agregar Nuevo Cliente</h1></div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form id="client-form" autocomplete="off">
            <div class="row mb-4 border-bottom pb-3">
                <div class="col-md-4">
                    <label for="tipo" class="form-label fw-bold">Tipo de Cliente</label>
                    <select class="form-select border-primary" name="tipo" id="tipo" required>
                        <option value="Particular" selected>Persona Particular</option>
                        <option value="Empresa">Empresa / Jurídico</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3" id="seccion-particular">
                <div class="col-md-4">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control input-particular" name="apellido" id="apellido" required>
                </div>
                <div class="col-md-5">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" class="form-control input-particular" name="nombres" id="nombres" required>
                </div>
                <div class="col-md-3">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control input-particular" name="dni" id="dni" required>
                </div>
            </div>

            <div class="row mb-3 d-none" id="seccion-empresa">
                <div class="col-md-8">
                    <label for="razon_social" class="form-label">Razón Social</label>
                    <input type="text" class="form-control input-empresa" name="razon_social" id="razon_social">
                </div>
                <div class="col-md-4">
                    <label for="cuit" class="form-label">CUIT</label>
                    <input type="text" class="form-control input-empresa" name="cuit" id="cuit">
                </div>
            </div>

            <div class="row mb-3 pt-3 border-top">
                <div class="col-md-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" id="telefono">
                </div>
                <div class="col-md-4">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo" id="correo">
                </div>
                <div class="col-md-4">
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input type="text" class="form-control" name="domicilio" id="domicilio">
                </div>
            </div>

            <div class="d-flex gap-2 pt-3 mt-4 border-top">
                <button type="submit" class="btn btn-custom-primary px-4">Guardar Cliente</button>
                <a href="<?= APP_URL ?>client" class="btn btn-custom-secondary px-4">Volver al listado</a>
            </div>
        </form>
    </div>
</div>