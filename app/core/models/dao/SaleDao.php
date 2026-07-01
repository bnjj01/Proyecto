<?php
namespace app\core\models\dao;

use app\core\models\dao\base\BaseDao;
use app\core\models\dao\base\InterfaceDao;

final class SaleDao extends BaseDao implements InterfaceDao {

    public function __construct(\PDO $conn) {
        parent::__construct($conn, "ventas");
    }

    public function save(array $data): void {
        $this->conn->exec("LOCK TABLES ventas_numeracion WRITE");
        
        $stmtNum = $this->conn->query("SELECT numero FROM ventas_numeracion");
        $numeroVenta = (int) $stmtNum->fetchColumn();
        
        $this->conn->exec("UPDATE ventas_numeracion SET numero = numero + 1");
        $this->conn->exec("UNLOCK TABLES");

        $this->conn->beginTransaction();

        try {
            $sqlVenta = "INSERT INTO ventas (numero_venta, fecha, cliente, forma_pago, total, usuarioId, estado) 
                         VALUES (:numero_venta, NOW(), :cliente, :forma_pago, :total, :usuarioId, 1)";
            $stmtVenta = $this->conn->prepare($sqlVenta);
            $stmtVenta->execute([
                'numero_venta' => $numeroVenta,
                'cliente'      => $data['cliente'],
                'forma_pago'   => $data['forma_pago'],
                'total'        => $data['total'],
                'usuarioId'    => $data['usuarioId']
            ]);

            $ventaId = $this->conn->lastInsertId();

            $sqlDetalle = "INSERT INTO ventas_detalle (ventaId, productoId, cantidad, precio_unitario, subtotal) 
                           VALUES (:ventaId, :productoId, :cantidad, :precio, :subtotal)";
            $stmtDetalle = $this->conn->prepare($sqlDetalle);

            $sqlStock = "UPDATE productos SET stock = stock - :cantidad WHERE id = :productoId AND stock >= :cantidad";
            $stmtStock = $this->conn->prepare($sqlStock);

            foreach ($data['detalles'] as $item) {
                $stmtDetalle->execute([
                    'ventaId'    => $ventaId,
                    'productoId' => $item['id'],
                    'cantidad'   => $item['cantidad'],
                    'precio'     => $item['precio'],
                    'subtotal'   => $item['subtotal']
                ]);

                $stmtStock->execute([
                    'cantidad'   => $item['cantidad'],
                    'productoId' => $item['id']
                ]);

                if ($stmtStock->rowCount() == 0) {
                    throw new \Exception("No hay stock suficiente para el producto: " . $item['nombre']);
                }
            }

           
            $this->conn->commit();

        } catch (\Exception $e) {
           
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function list(array $filters = []): array {
        $sql = "SELECT v.id, v.numero_venta, DATE_FORMAT(v.fecha, '%d/%m/%Y %H:%i') as fecha, 
                       v.cliente, v.forma_pago, v.total, v.estado, u.cuenta as vendedor
                FROM ventas v
                LEFT JOIN usuarios u ON v.usuarioId = u.id";
                
        $clauses = [];
        $parameters = [];

        if (isset($filters['filtroCliente']) && $filters['filtroCliente'] !== '') {
            $clauses[] = "(v.cliente LIKE :filtro OR v.numero_venta LIKE :filtro)";
            $parameters['filtro'] = "%" . $filters['filtroCliente'] . "%";
        }

        if (count($clauses) > 0) {
            $sql .= " WHERE " . implode(" AND ", $clauses);
        }

        $sql .= " ORDER BY v.id DESC";
        
        return $this->selectQuery($sql, $parameters);
    }

    public function load(int $id): array {
        $sql = "SELECT v.*, DATE_FORMAT(v.fecha, '%d/%m/%Y %H:%i') as fecha_formateada, u.cuenta as vendedor 
                FROM ventas v 
                LEFT JOIN usuarios u ON v.usuarioId = u.id 
                WHERE v.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $venta = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$venta) {
            throw new \Exception("Venta no encontrada.");
        }

        $sqlDetalles = "SELECT d.*, p.codigo, p.nombre 
                        FROM ventas_detalle d 
                        INNER JOIN productos p ON d.productoId = p.id 
                        WHERE d.ventaId = :ventaId";
        $stmtDetalles = $this->conn->prepare($sqlDetalles);
        $stmtDetalles->execute(['ventaId' => $id]);
    
        $venta['detalles'] = $stmtDetalles->fetchAll(\PDO::FETCH_ASSOC);

        return $venta;
    }

    public function update(array $data): void {
        $sql = "UPDATE ventas 
                SET cliente = :cliente, 
                    forma_pago = :forma_pago 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'cliente' => $data['cliente'],
            'forma_pago' => $data['forma_pago']
        ]);
    }

    public function delete(int $id): void {
        $this->conn->beginTransaction();

        try {
            $stmtCheck = $this->conn->prepare("SELECT estado FROM ventas WHERE id = :id");
            $stmtCheck->execute(['id' => $id]);
            $estadoActual = $stmtCheck->fetchColumn();

            if ($estadoActual === false) {
                throw new \Exception('No se encontró la venta a eliminar.');
            }
            if ($estadoActual == 0) {
                throw new \Exception('Esta venta ya fue anulada previamente. El stock ya fue devuelto.');
            }

            $stmtAnular = $this->conn->prepare("UPDATE ventas SET estado = 0 WHERE id = :id");
            $stmtAnular->execute(['id' => $id]);

            $stmtDetalles = $this->conn->prepare("SELECT productoId, cantidad FROM ventas_detalle WHERE ventaId = :id");
            $stmtDetalles->execute(['id' => $id]);
            $detalles = $stmtDetalles->fetchAll(\PDO::FETCH_ASSOC);

            $stmtStock = $this->conn->prepare("UPDATE productos SET stock = stock + :cantidad WHERE id = :productoId");
            foreach ($detalles as $item) {
                $stmtStock->execute([
                    'cantidad'   => $item['cantidad'],
                    'productoId' => $item['productoId']
                ]);
            }
            $this->conn->commit();

        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}