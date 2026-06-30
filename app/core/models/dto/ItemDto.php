<?php

namespace app\core\models\dto;

final class ItemDto {

    private string $nombre, $codigo, $descripcion;
    private int $id, $categoriaId, $stock;
    private float $precio;

    public function __construct(array $data = [])
    {
        $this->setId($data['id'] ?? 0);
        $this->setNombre($data['nombre'] ?? "");
        $this->setCodigo($data['codigo'] ?? "");
        $this->setDescripcion($data['descripcion'] ?? "");
        $this->setCategoriaId($data['categoriaId'] ?? 0);
        $this->setStock($data['stock'] ?? 0);
        $this->setPrecio($data['precio'] ?? 0.0);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function getCodigo(): ?string {
        return $this->codigo;
    }

    public function getDescripcion(): ?string {
        return $this->descripcion;
    }

    public function getCategoriaId(): ?int {
        return $this->categoriaId;
    }

    public function getPrecio(): ?float {
        return $this->precio;
    }

    public function getStock(): ?int {
        return $this->stock;
    }

    public function setId(int $id): void{
        $this->id = ($id > 0) ? $id : 0;
    }

    public function setNombre(string $nombre): void{
        $nombreTrimeado = trim($nombre);
        $this->nombre = (strlen($nombreTrimeado) > 0 && strlen($nombreTrimeado) <= 100) ? $nombreTrimeado : "";
    }

    public function setCodigo(string $codigo): void{
        $this->codigo = (strlen($codigo) > 0 && strlen($codigo) <= 25) ? $codigo : "";
    }

    public function setDescripcion(string $descripcion): void{
        $this->descripcion = (strlen($descripcion) > 0 && strlen($descripcion) <= 900) ? $descripcion : "";
    }

    public function setCategoriaId(int $categoriaId): void{
        $this->categoriaId = $categoriaId > 0 ? $categoriaId : 0;
    }

    public function setPrecio(float $precio): void{
        $this->precio = $precio > 0 ? $precio : 0.0;
    }

    public function setStock(int $stock): void{
        $this->stock = $stock > 0 ? $stock : 0;
    }


    public function toArrayForSave(): array {
        return [
            'nombre'        => $this->getNombre(),
            'codigo'        => $this->getCodigo(),
            'descripcion'   => $this->getDescripcion(),
            'categoriaId'   => $this->getCategoriaId(),
            'precio'        => $this->getPrecio(),
            'stock'         => $this->getStock()
        ];
    }
    public function toArrayForUpdate(): array {
        return [
            'id'            => $this->getId(),
            'nombre'        => $this->getNombre(),
            'codigo'        => $this->getCodigo(),
            'descripcion'   => $this->getDescripcion(),
            'categoriaId'   => $this->getCategoriaId(),
            'precio'        => $this->getPrecio(),
            'stock'         => $this->getStock()
        ];
    }
}