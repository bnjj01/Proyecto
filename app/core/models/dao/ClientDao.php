<?php
namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class ClientDao extends BaseDao implements InterfaceDao {

    public function __construct(\PDO $conn) {
        parent::__construct($conn, "clientes");
    }

    public function load(int $id): array {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function save(array $data): void {
        $sql = "INSERT INTO {$this->table} 
                (tipo, apellido, nombres, dni, razon_social, cuit, telefono, correo, domicilio, estado) 
                VALUES (:tipo, :apellido, :nombres, :dni, :razon_social, :cuit, :telefono, :correo, :domicilio, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function update(array $data): void {
        if (empty($data['id'])) throw new \Exception("ID requerido para actualizar.");
        
        $sql = "UPDATE {$this->table} 
                SET apellido = :apellido, nombres = :nombres, dni = :dni, 
                    razon_social = :razon_social, cuit = :cuit, telefono = :telefono, 
                    correo = :correo, domicilio = :domicilio 
                WHERE id = :id";
        unset($data['tipo']);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function delete(int $id): void {
        $sql = "UPDATE {$this->table} SET estado = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró el cliente o ya estaba eliminado.");
        }
    }

    public function list(array $filters = []): array {
        $sql = "SELECT * FROM {$this->table} WHERE estado = 1";
        $clauses = [];
        $parameters = [];

        if (isset($filters['filtroBusqueda']) && $filters['filtroBusqueda'] !== '') {
            $clauses[] = "(apellido LIKE :filtro OR nombres LIKE :filtro OR razon_social LIKE :filtro OR dni LIKE :filtro OR cuit LIKE :filtro)";
            $parameters['filtro'] = "%" . $filters['filtroBusqueda'] . "%";
        }

        if (isset($filters['filtroTipo']) && $filters['filtroTipo'] !== '') {
            $clauses[] = "tipo = :tipo";
            $parameters['tipo'] = $filters['filtroTipo'];
        }

        if (count($clauses) > 0) {
            $sql .= " AND " . implode(" AND ", $clauses);
        }

        $sql .= " ORDER BY id DESC";
        return $this->selectQuery($sql, $parameters);
    }
}