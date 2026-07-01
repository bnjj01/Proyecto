<?php
namespace app\core\models\dto;

final class CategoryDto {
    private int $id;
    private string $nombre;

    public function __construct(array $data = []) {
        $idSeguro = (isset($data['id']) && $data['id'] !== "") ? (int)$data['id'] : 0;

        $this->setId($idSeguro);
        $this->setNombre($data['nombre'] ?? "");
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setId(int $id): void {
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setNombre(string $nombre): void {
        $nombreLimpio = trim($nombre);
        $this->nombre = (strlen($nombreLimpio) > 0 && strlen($nombreLimpio) <= 100) ? $nombreLimpio : "";
    }

    public function toArrayForSave(): array {
        return [
            'nombre' => $this->getNombre(),
        ];
    }
    public function toArrayForUpdate(): array {
        return [
            'id'     => $this->getId(),
            'nombre' => $this->getNombre(),
        ];
    }
}