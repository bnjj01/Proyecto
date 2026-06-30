<?php
namespace app\core\services;

use app\core\models\dao\CategoryDao;
use app\core\models\dto\CategoryDto;
use app\core\services\base\BaseService;
use app\libs\database\Connection;

class CategoryService extends BaseService {

    function __construct()
    {
        parent::__construct(new CategoryDao(Connection::get()));
    }

    public function list(array $filters = []): array {
        return $this->dao->list($filters);
    }

    public function save(CategoryDto $dto): void {
        if ($dto->getNombre() === "") {
            throw new \Exception("El nombre de la categoría es obligatorio y debe ser válido.");
        }

        $this->dao->save($dto->toArrayForSave());
    }
}