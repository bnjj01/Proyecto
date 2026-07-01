<?php
namespace app\core\services;

use app\core\models\dao\ClientDao;
use app\core\models\dto\ClientDto;
use app\core\services\base\BaseService;
use app\libs\database\Connection;

final class ClientService extends BaseService {
    
    function __construct() {
        parent::__construct(new ClientDao(Connection::get()));
    }

    public function save(ClientDto $dto): void {
        $this->validate($dto);
        $this->dao->save($dto->toArrayForSave());
    }

    public function update(ClientDto $dto): void {
        $this->validate($dto);
        $this->modify($dto->toArrayForUpdate());
    }

    public function list(array $filters): array {
        return $this->dao->list($filters);
    }

    private function validate(ClientDto $dto): void {
        if ($dto->getTipo() === 'Particular') {
            if ($dto->getApellido() == "" || $dto->getNombres() == "") {
                throw new \Exception("Para un cliente Particular, el Apellido y Nombre son obligatorios.");
            }
            if ($dto->getDni() == "") {
                throw new \Exception("El DNI es obligatorio.");
            }
        } else if ($dto->getTipo() === 'Empresa') {
            if ($dto->getRazonSocial() == "") {
                throw new \Exception("Para una Empresa, la Razón Social es obligatoria.");
            }
            if ($dto->getCuit() == "") {
                throw new \Exception("El CUIT es obligatorio.");
            }
        } else {
            throw new \Exception("Tipo de cliente inválido.");
        }
    }
}