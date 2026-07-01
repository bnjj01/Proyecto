<?php
namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class CategoryDao extends BaseDao implements InterfaceDao {

    public function __construct(\PDO $conn) {
        // Asegurate de que tu tabla en MySQL se llame exactamente 'categorias'
        parent::__construct($conn, "categorias"); 
    }

    public function list(array $filters = []): array {
        // Seleccionamos los campos básicos de la categoría
        $sql = "SELECT id, nombre FROM {$this->table}";
        
        $clauses = [];
        $parameters = [];

        // Filtro dinámico: Si el JS manda algo en "filtroNombre", armamos el WHERE
        if (isset($filters['filtroNombre']) && $filters['filtroNombre'] !== '') {
            $clauses[] = "nombre LIKE :nombre";
            $parameters['nombre'] = "%" . $filters['filtroNombre'] . "%";
        }

        if (count($clauses) > 0) {
            $sql .= " WHERE " . implode(" AND ", $clauses);
        }

        // Ordenamos alfabéticamente por defecto
        $sql .= " ORDER BY nombre ASC";

        return $this->selectQuery($sql, $parameters);
    }

    public function save(array $data): void {
        // Adaptá esta consulta si tu tabla tiene más columnas (ej: fechaCreacion)
        $sql = "INSERT INTO {$this->table} (nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'nombre' => $data['nombre']
        ]);
    }

    public function update(array $data): void {
        if (empty($data['id'])) {
            throw new \Exception("El ID es requerido para actualizar.");
        }
        $sql = "UPDATE {$this->table} SET nombre = :nombre WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id'     => $data['id'],
            'nombre' => $data['nombre']
        ]);
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró la categoría para eliminar.");
        }
    }
    
    public function load(int $id): array {
        return [];
    }
}