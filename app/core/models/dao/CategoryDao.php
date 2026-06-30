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
        $sql = "SELECT id, nombre, estado FROM {$this->table}";
        
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
        $sql = "INSERT INTO {$this->table} (nombre, estado) VALUES (:nombre, :estado)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'nombre' => $data['nombre'],
            'estado' => $data['estado']
        ]);
    }

    // --- Métodos obligatorios de InterfaceDao (Dejalos así hasta que los necesites) ---
    
    public function load(int $id): array {
        return [];
    }

    public function update(array $data): void {
        // Lógica de update a futuro
    }

    public function delete(int $id): void {
        // Lógica de delete a futuro
    }
}