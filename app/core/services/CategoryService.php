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
    
    public function update(CategoryDto $dto): void {
        if ($dto->getId() <= 0) {
            throw new \Exception("ID de categoría inválido.");
        }
        if ($dto->getNombre() === "") {
            throw new \Exception("El nombre es obligatorio.");
        }
        $this->dao->update($dto->toArrayForUpdate());
    }

    public function delete(int $id): void {
        if ($id <= 0) {
            throw new \Exception("ID de categoría inválido.");
        }
        $this->dao->delete($id);
    }
}