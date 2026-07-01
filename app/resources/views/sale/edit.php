<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center border-bottom pb-2 title-custom">
        <h1 class="h3 mb-0">
            Detalle de Venta #<?= str_pad($this->venta['numero_venta'], 6, '0', STR_PAD_LEFT) ?>
        </h1>
        <div class="btn-group" role="group">
            <button style="margin-right: 10px; border-radius: 5px;" type="button" class="btn btn-secondary btn-sm" id="btn-exportar-recibo">Exportar a PDF</button>
            <button style="margin-right: 10px; border-radius: 5px;" type="button" class="btn btn-danger btn-sm" id="btn-eliminar-venta">Eliminar venta</button>
            <a href="<?= APP_URL ?>sale" style="margin-right: 10px; border-radius: 5px;" class="btn btn-secondary btn-sm">Volver al listado</a>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body bg-light">
        <form id="form-editar-venta" class="row g-3">
            <input type="hidden" name="id" value="<?= $this->venta['id'] ?>">

            <div class="col-md-4">
                <label class="form-label">Cliente</label>
                <input type="text" class="form-control" name="cliente" value="<?= htmlspecialchars($this->venta['cliente']) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Forma de pago</label>
                <select class="form-select" name="forma_pago">
                    <option value="Efectivo" <?= $this->venta['forma_pago'] == 'Efectivo' ? 'selected' : '' ?>>Efectivo</option>
                    <option value="Tarjeta" <?= $this->venta['forma_pago'] == 'Tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
                    <option value="Transferencia" <?= $this->venta['forma_pago'] == 'Transferencia' ? 'selected' : '' ?>>Transferencia</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold text-muted">Estado de la Venta</label>
                <div class="fs-5 fw-bold mb-0">
                    <?php if(($this->venta['estado'] ?? 1) == 1): ?>
                        <span class="text-success">Válida</span>
                    <?php else: ?>
                        <span class="text-danger">Anulada</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-warning w-100">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white fw-bold">
        Productos Facturados
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->venta['detalles'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['codigo']) ?></td>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td>$ <?= number_format($item['precio_unitario'], 2) ?></td>
                            <td><?= $item['cantidad'] ?></td>
                            <td>$ <?= number_format($item['subtotal'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-secondary fs-5">
                        <th colspan="4" class="text-end">TOTAL:</th>
                        <th class="text-success fw-bold">$ <?= number_format($this->venta['total'], 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>