<?php

namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class ItemDao extends BaseDao implements InterfaceDao{

    public function __construct(\PDO $conn)
    {
        parent::__construct($conn, "productos");
    }

    public function load(int $id): array{
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    public function save(array $data): void{
        $this->validateCodigo(0, $data['codigo']);
        $sql = "INSERT INTO {$this->table} VALUES(DEFAULT, :nombre, :codigo, :descripcion, :categoriaId, :precio, :stock)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function update(array $data): void{
        if (empty($data['id'])) {
            throw new \Exception("El ID es requerido para actualizar un registro.");
        }
        
        $this->validateCodigo($data['id'], $data['codigo']);
        
        $sql = "UPDATE {$this->table} 
                SET nombre = :nombre, 
                    codigo = :codigo, 
                    descripcion = :descripcion, 
                    categoriaId = :categoriaId, 
                    precio = :precio, 
                    stock = :stock 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }


    public function delete(int $id): void{
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($stmt->rowCount() == 0) {
            throw new \Exception("No se encontró ningún registro con el ID especificado.");
        }
    }

    public function list(array $filters): array{
        $sql = "SELECT id, nombre, codigo, descripcion, categoriaId, precio, stock FROM {$this->table}";
        
        $clauses = [];
        $parameters = [];

        if (isset($filters['filtroNombre']) && $filters['filtroNombre'] !== '') {
            
            $clauses[] = "(nombre LIKE :nombre OR codigo LIKE :nombre)";
            $parameters['nombre'] = "%" . $filters['filtroNombre'] . "%";
        }

        if (isset($filters['filtroCategoria']) && $filters['filtroCategoria'] !== '') {
            $clauses[] = "categoriaId = :categoriaId";
            $parameters['categoriaId'] = $filters['filtroCategoria'];
        }

        if (count($clauses) > 0) {
            $sql .= " WHERE " . implode(" AND ", $clauses);
        }

        return $this->selectQuery($sql, $parameters);
    }

    private function validateCodigo(int $id, string $codigo): void{
        $sql = "SELECT id FROM {$this->table} WHERE codigo = :codigo AND id != :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id'     => $id,
            'codigo' => $codigo
        ]);
        if($stmt->rowCount() != 0){
            throw new \Exception("El codigo {$codigo} ya esta siendo usado por otro producto.");
        }
    }

    public function suggestive(array $filters): array{
        // $sql = "SELECT SQL_CALC_FOUND_ROWS mat.id, mat.nombre, mat.codigo, mat.estado, mat.tipo";
        // $sql .= " FROM materiales as mat";

        // $parameters = [];
        // $clauses = [];

        // //Se preparan los parámetros con los token de la consulta preparada, y las condiciones para el WHERE
        // if(isset($filters["tipo"]) && $filters["tipo"] != ""){
        //     $clauses["tipo"] = "(tipo = :tipo)";
        //     $parameters["tipo"] = $filters["tipo"];
        // }
        // if(isset($filters["valueToSearch"])){
        //     $clauses["valueToSearch"] = "(mat.nombre LIKE :value OR mat.codigo LIKE :value)";
        //     $parameters["value"] = "%" . $filters["valueToSearch"] . "%"; 
        // }

        // //Se arma la clásula WHERE
        // if(count($clauses) > 0){
        //     $sql .= " WHERE " . implode(" AND ", $clauses);
        // }
        // //Se arma la clásula ORDER BY
        // $sql .= (isset($filters["order"]) && strlen($filters["order"]) > 0) ? " ORDER BY {$filters["order"]}" : " ORDER BY mat.nombre ASC";
        // //Se arma la clásula LIMIT para el paginador
        // if(isset($filters["startIndex"]) && isset($filters["offSet"]) && ((int)$filters["offSet"]) > 0){
        //     $sql .= " LIMIT {$filters["startIndex"]}, {$filters["offSet"]}";
        // }

        // return $this->selectQuery($sql, $parameters);
        return [];
    }

}