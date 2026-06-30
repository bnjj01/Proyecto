<?php

namespace app\core\services\base;
use app\core\models\dao\base\InterfaceDao;

class BaseService {
    protected $dao;

    public function __construct(InterfaceDao $dao) {
        $this->dao = $dao;
    }

    public function create(array $data): void {
        $this->dao->save($data);
    }

    public function getById(int $id): array {
        return $this->dao->load($id);
    }

    public function getAll(array $filters = []): array {
        return $this->dao->list($filters);
    }

    public function modify(array $data): void {
        $this->dao->update($data);
    }

    public function remove(int $id): void {
        $this->dao->delete($id);
    }
}
?>