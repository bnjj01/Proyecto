<?php

namespace app\core\services\base;

interface InterfaceService {
    public function getById(int $id): array;
    public function getAll(array $filters = []): array;
    public function create(array $data): void;
    public function modify(array $data): void;
    public function remove(int $id): void;
}
?>