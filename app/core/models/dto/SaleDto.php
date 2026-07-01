<?php
namespace app\core\models\dto;

final class SaleDto {
    private string $cliente;
    private string $forma_pago;
    private array $detalles;
    private float $total;

    public function __construct(array $data = []) {
        $this->cliente = trim($data['cliente'] ?? "Consumidor Final");
        $this->forma_pago = trim($data['forma_pago'] ?? "Efectivo");
        $this->detalles = $data['detalles'] ?? [];
        
        // Calculamos el total de forma segura en el backend
        $this->total = 0;
        foreach ($this->detalles as $item) {
            $this->total += (float)$item['precio'] * (int)$item['cantidad'];
        }
    }

    public function getCliente(): string { return $this->cliente; }
    public function getFormaPago(): string { return $this->forma_pago; }
    public function getDetalles(): array { return $this->detalles; }
    public function getTotal(): float { return $this->total; }

    public function toArrayForSave(): array {
        return [
            'cliente'    => $this->getCliente(),
            'forma_pago' => $this->getFormaPago(),
            'total'      => $this->getTotal(),
            'detalles'   => $this->getDetalles()
        ];
    }
}