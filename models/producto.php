<?php
/*
|--------------------------------------------------------------------------
| MODELO: Producto
|--------------------------------------------------------------------------
| Este modelo se encarga de consultar la información de los productos
| registrados en la base de datos.
|
| Funciones principales:
| - Obtener todos los productos activos
| - Obtener un producto específico por ID
| - Consultar el stock disponible desde la tabla almacen
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/db.php';

class Producto {

    /*
    |--------------------------------------------------------------------------
    | obtenerTodos()
    |--------------------------------------------------------------------------
    | Obtiene todos los productos activos del catálogo.
    |
    | Se realiza una unión (INNER JOIN) entre:
    | - tabla productos
    | - tabla almacen
    |
    | Esto permite mostrar:
    | - nombre
    | - descripción
    | - precio
    | - imagen
    | - stock actual
    |--------------------------------------------------------------------------
    */
    public static function obtenerTodos() {
        global $conexion;

        $sql = "SELECT p.*, a.stock_actual AS stock
                FROM productos p
                INNER JOIN almacen a ON p.id = a.id_producto
                WHERE p.estado = 'activo'";

        $stmt = $conexion->prepare($sql);

        // Ejecuta la consulta SQL
        $stmt->execute();

        // Retorna todos los productos encontrados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | obtenerPorId($id)
    |--------------------------------------------------------------------------
    | Obtiene un producto específico usando su ID.
    |
    | También consulta el stock disponible desde la tabla almacen.
    |
    | Parámetro:
    | - $id → identificador del producto
    |--------------------------------------------------------------------------
    */
    public static function obtenerPorId($id) {
        global $conexion;

        $sql = "SELECT p.*, a.stock_actual AS stock
                FROM productos p
                INNER JOIN almacen a ON p.id = a.id_producto
                WHERE p.id = :id AND p.estado = 'activo'";

        $stmt = $conexion->prepare($sql);

        // Se enlaza el parámetro ID para evitar inyección SQL
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecuta la consulta
        $stmt->execute();

        // Retorna un único producto
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>