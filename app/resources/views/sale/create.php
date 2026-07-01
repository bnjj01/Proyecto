<div class="row mb-4">
    <div class="col">
        <h1 class="h3 pb-2 title-custom">Punto de Venta (Nueva Venta)</h1>
    </div>
</div>

<form id="sale-form" autocomplete="off">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-bold">1. Datos Básicos</div>
        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label for="cliente" class="form-label">Seleccionar Cliente</label>
                <select class="form-select" id="cliente" name="cliente" required>
                    <option value="Consumidor Final" selected>Consumidor Final</option>
                    </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="forma_pago" class="form-label">Forma de Pago</label>
                <select class="form-select" id="forma_pago" name="forma_pago" required>
                    <option value="Efectivo" selected>Efectivo</option>
                    <option value="Debito">Tarjeta de Débito</option>
                    <option value="Transferencia">Transferencia</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-bold">2. Detalle de Productos</div>
        <div class="card-body">
            <div class="row align-items-end mb-4 bg-light p-3 rounded">
                <div class="col-md-6">
                    <label for="select-producto" class="form-label">Seleccionar Producto</label>
                    <select class="form-select" id="select-producto">
                        <option value="" selected disabled>Cargando catálogo...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="input-cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="input-cantidad" min="1" value="1">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary w-100" id="btn-agregar-carrito">Agregar a la lista</button>
                </div>
            </div>

            <table class="table table-bordered text-center" id="tabla-carrito">
                <thead class="table-secondary">
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Precio Unit.</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="fila-vacia"><td colspan="6" class="text-muted">El carrito está vacío</td></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end fs-5">TOTAL A PAGAR:</th>
                        <th colspan="2" class="text-start fs-5 text-success fw-bold" id="total-venta">$ 0.00</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success px-5 fw-bold fs-5" id="btn-finalizar">Finalizar Venta</button>
        <a href="<?= APP_URL ?>sale" class="btn btn-outline-secondary px-4">Cancelar</a>
    </div>
</form>