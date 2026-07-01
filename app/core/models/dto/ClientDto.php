<?php
namespace app\core\models\dto;

final class ClientDto {
    private int $id;
    private string $tipo, $apellido, $nombres, $dni, $razon_social, $cuit, $telefono, $correo, $domicilio;

    public function __construct(array $data = []) {
        $this->id = (int)($data['id'] ?? 0);
        $this->tipo = trim($data['tipo'] ?? 'Particular');
        $this->apellido = trim($data['apellido'] ?? '');
        $this->nombres = trim($data['nombres'] ?? '');
        $this->dni = trim($data['dni'] ?? '');
        $this->razon_social = trim($data['razon_social'] ?? '');
        $this->cuit = trim($data['cuit'] ?? '');
        $this->telefono = trim($data['telefono'] ?? '');
        $this->correo = trim($data['correo'] ?? '');
        $this->domicilio = trim($data['domicilio'] ?? '');
    }

    public function getId(): int { return $this->id; }
    public function getTipo(): string { return $this->tipo; }
    public function getApellido(): string { return $this->apellido; }
    public function getNombres(): string { return $this->nombres; }
    public function getDni(): string { return $this->dni; }
    public function getRazonSocial(): string { return $this->razon_social; }
    public function getCuit(): string { return $this->cuit; }
    public function getTelefono(): string { return $this->telefono; }
    public function getCorreo(): string { return $this->correo; }
    public function getDomicilio(): string { return $this->domicilio; }

    public function toArrayForSave(): array {
        return [
            'tipo'         => $this->getTipo(),
            'apellido'     => $this->getApellido(),
            'nombres'      => $this->getNombres(),
            'dni'          => $this->getDni(),
            'razon_social' => $this->getRazonSocial(),
            'cuit'         => $this->getCuit(),
            'telefono'     => $this->getTelefono(),
            'correo'       => $this->getCorreo(),
            'domicilio'    => $this->getDomicilio()
        ];
    }
    
    public function toArrayForUpdate(): array {
        $data = $this->toArrayForSave();
        $data['id'] = $this->getId();
        return $data;
    }
}