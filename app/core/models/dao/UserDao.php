<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class UserDao extends BaseDao implements InterfaceDao{

    public function __construct(\PDO $conn)
    {
        parent::__construct($conn, "usuarios");
    }

    public function load(int $id): array{
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function save(array $data): void{
        $sql = "INSERT INTO {$this->table} VALUES(DEFAULT, :apellido, :nombres, :cuenta, :perfil, :clave, :correo, 1, NOW(), 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function login(string $cuenta): array {
        $sql = "SELECT user.id, user.apellido, user.nombres, user.cuenta, user.clave, user.perfil, user.estado, user.resetPass";
        $sql .= " FROM usuarios AS user";
        $sql .= " WHERE (cuenta = :cuenta OR correo = :cuenta)";
        $result = $this->selectQuery($sql, ["cuenta" => $cuenta]);
        
        if (count($result) != 1) {
            throw new \Exception("El nombre de usuario o la contraseña no coinciden");
        }
        
        return $result[0];
    }

    public function updatePassword(array $data): void{
        if (empty($data['id']) || empty($data['clave'])) {
            throw new \Exception("El ID y la nueva clave son requeridos.");
        }

        $sql = "UPDATE {$this->table} SET clave = :clave WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            'id'    => $data['id'],
            'clave' => password_hash($data['clave'], PASSWORD_BCRYPT)
        ]);
    }
    
    public function update(array $data): void{
        if (empty($data['id'])) {
            throw new \Exception("El ID es requerido para actualizar un registro.");
        }
        
        $sql = "UPDATE {$this->table} 
                SET apellido = :apellido, 
                    nombres = :nombres, 
                    cuenta = :cuenta, 
                    perfil = :perfil, 
                    correo = :correo 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'id'        => $data['id'],
            'apellido'  => $data['apellido'],
            'nombres'   => $data['nombres'],
            'cuenta'    => $data['cuenta'],
            'perfil'    => $data['perfil'],
            'correo'    => $data['correo']
        ]);
    }

    public function delete(int $id): void{
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró ningún registro con el ID especificado.");
        }
    }

    public function list(array $filters = []): array {
        $sql = "SELECT id, apellido, nombres, cuenta, perfil, correo, estado FROM {$this->table}";
        
        $clauses = [];
        $parameters = [];

        if (isset($filters['filtroNombre']) && $filters['filtroNombre'] !== '') {
            $clauses[] = "(nombres LIKE :nombre OR apellido LIKE :nombre OR cuenta LIKE :nombre)";
            $parameters['nombre'] = "%" . $filters['filtroNombre'] . "%";
        }

        if (isset($filters['filtroPerfil']) && $filters['filtroPerfil'] !== '') {
            $clauses[] = "perfil = :perfil";
            $parameters['perfil'] = $filters['filtroPerfil'];
        }

        if (count($clauses) > 0) {
            $sql .= " WHERE " . implode(" AND ", $clauses);
        }

        return $this->selectQuery($sql, $parameters);
    }

    public function enable(int $id): void {
        $sql = "UPDATE {$this->table} SET estado = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró ningún registro con el ID especificado.");
        }
    }

    public function disable(int $id): void {
        $sql = "UPDATE {$this->table} SET estado = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró ningún registro con el ID especificado.");
        }
    }

    public function reset(int $id): void {
        $sql = "UPDATE {$this->table} SET resetPass = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró ningún registro con el ID especificado.");
        }
    }
}