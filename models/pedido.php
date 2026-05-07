<?php
require_once __DIR__ . '/../config/db.php';

class Pedido {

    /*
    =========================================
    CREAR PEDIDO
    =========================================
    */
    public static function crearPedido($usuario_id, $carrito, $metodo_pago) {

        global $conexion;

        try {

            $conexion->beginTransaction();

            $total = 0;

            /*
            =========================================
            CALCULAR TOTAL
            =========================================
            */
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            /*
            =========================================
            INSERTAR PEDIDO
            =========================================
            */
            $sqlPedido = "
                INSERT INTO pedidos
                (usuario_id, total, estado, metodo_pago)
                VALUES
                (:usuario_id, :total, 'Pendiente', :metodo_pago)
            ";

            $stmtPedido = $conexion->prepare($sqlPedido);

            $stmtPedido->bindParam(':usuario_id', $usuario_id);
            $stmtPedido->bindParam(':total', $total);
            $stmtPedido->bindParam(':metodo_pago', $metodo_pago);

            $stmtPedido->execute();

            $pedido_id = $conexion->lastInsertId();

            /*
            =========================================
            INSERTAR DETALLE PEDIDO
            =========================================
            */
            foreach ($carrito as $item) {

                $subtotal = $item['precio'] * $item['cantidad'];

                $sqlDetalle = "
                    INSERT INTO detalle_pedido
                    (
                        pedido_id,
                        producto_id,
                        nombre_producto,
                        imagen_producto,
                        precio,
                        cantidad,
                        subtotal
                    )
                    VALUES
                    (
                        :pedido_id,
                        :producto_id,
                        :nombre_producto,
                        :imagen_producto,
                        :precio,
                        :cantidad,
                        :subtotal
                    )
                ";

                $stmtDetalle = $conexion->prepare($sqlDetalle);

                $stmtDetalle->bindParam(':pedido_id', $pedido_id);
                $stmtDetalle->bindParam(':producto_id', $item['id']);
                $stmtDetalle->bindParam(':nombre_producto', $item['nombre']);
                $stmtDetalle->bindParam(':imagen_producto', $item['imagen']);
                $stmtDetalle->bindParam(':precio', $item['precio']);
                $stmtDetalle->bindParam(':cantidad', $item['cantidad']);
                $stmtDetalle->bindParam(':subtotal', $subtotal);

                $stmtDetalle->execute();

                /*
                =========================================
                DESCONTAR STOCK
                =========================================
                */
                $sqlStock = "
                    UPDATE almacen
                    SET stock_actual = stock_actual - :cantidad
                    WHERE id_producto = :producto_id
                ";

                $stmtStock = $conexion->prepare($sqlStock);

                $stmtStock->bindParam(':cantidad', $item['cantidad']);
                $stmtStock->bindParam(':producto_id', $item['id']);

                $stmtStock->execute();
            }

            /*
            =========================================
            CONFIRMAR TRANSACCIÓN
            =========================================
            */
            $conexion->commit();

            return $pedido_id;

        } catch (Exception $e) {

            /*
            =========================================
            CANCELAR SI HAY ERROR
            =========================================
            */
            $conexion->rollBack();

            return false;
        }
    }

    /*
    =========================================
    OBTENER PEDIDOS DEL USUARIO
    =========================================
    */
    public static function obtenerPedidosPorUsuario($usuario_id) {

        global $conexion;

        $sql = "
            SELECT
                pedidos.id AS pedido_id,

                detalle_pedido.producto_id,
                detalle_pedido.nombre_producto,
                detalle_pedido.cantidad,

                productos.imagen,

                pedidos.metodo_pago,
                pedidos.total,
                pedidos.estado

            FROM pedidos

            INNER JOIN detalle_pedido
                ON pedidos.id = detalle_pedido.pedido_id

            INNER JOIN productos
                ON detalle_pedido.producto_id = productos.id

            WHERE pedidos.usuario_id = :usuario_id

            ORDER BY pedidos.id DESC
        ";

        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':usuario_id', $usuario_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>