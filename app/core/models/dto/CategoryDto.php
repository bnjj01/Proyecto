<?php
namespace app\core\models\dto;

final class CategoryDto {
    private int $id;
    private string $nombre;
    private int $estado;

    public function __construct(array $data = []) {
        $this->setId($data['id'] ?? 0);
        $this->setNombre($data['nombre'] ?? "");
        $this->setEstado($data['estado'] ?? 1);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getEstado(): int {
        return $this->estado;
    }

    public function setId(int $id): void {
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setNombre(string $nombre): void {
        $nombreLimpio = trim($nombre);
        $this->nombre = (strlen($nombreLimpio) > 0 && strlen($nombreLimpio) <= 100) ? $nombreLimpio : "";
    }

    public function setEstado(int $estado): void {
        $this->estado = ($estado === 0 || $estado === 1) ? $estado : 1;
    }

    public function toArrayForSave(): array {
        return [
            'nombre' => $this->getNombre(),
            'estado' => $this->getEstado()
        ];
    }
}