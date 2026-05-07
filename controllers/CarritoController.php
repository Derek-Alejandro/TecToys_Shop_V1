<?php

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config/db.php';

class CarritoController {

    // ======================================
    // AGREGAR PRODUCTO AL CARRITO
    // ======================================

    public function agregar($id) {

        $producto = Producto::obtenerPorId($id);

        // Validar existencia y stock
        if (!$producto || $producto['stock'] <= 0) {

            header("Location: index.php");
            exit;
        }

        // Crear carrito si no existe
        if (!isset($_SESSION['carrito'])) {

            $_SESSION['carrito'] = [];
        }

        $cantidadActual = $_SESSION['carrito'][$id]['cantidad'] ?? 0;

        // Validar stock máximo
        if ($cantidadActual < $producto['stock']) {

            $_SESSION['carrito'][$id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen'],
                'cantidad' => $cantidadActual + 1
            ];
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // ======================================
    // MOSTRAR CARRITO
    // ======================================

    public function verCarrito() {

        $carrito = $_SESSION['carrito'] ?? [];

        require __DIR__ . '/../views/carrito.php';
    }

    // ======================================
    // ELIMINAR PRODUCTO
    // ======================================

    public function eliminar($id) {

        if (isset($_SESSION['carrito'][$id])) {

            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // ======================================
    // VACIAR CARRITO
    // ======================================

    public function vaciar() {

        unset($_SESSION['carrito']);

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // ======================================
    // AUMENTAR CANTIDAD
    // ======================================

    public function sumarCantidad($id) {

        if (!isset($_SESSION['carrito'][$id])) {

            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $producto = Producto::obtenerPorId($id);

        // Validar stock disponible
        if ($_SESSION['carrito'][$id]['cantidad'] < $producto['stock']) {

            $_SESSION['carrito'][$id]['cantidad']++;
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    // ======================================
    // DISMINUIR CANTIDAD
    // ======================================

    public function restarCantidad($id) {

        if (!isset($_SESSION['carrito'][$id])) {

            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $_SESSION['carrito'][$id]['cantidad']--;

        // Si llega a 0, eliminar producto
        if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {

            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }
}

?>