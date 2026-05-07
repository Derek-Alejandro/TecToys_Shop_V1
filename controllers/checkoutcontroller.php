<?php

require_once __DIR__ . '/../models/Pedido.php';

class CheckoutController {

    // ======================================
    // MOSTRAR CHECKOUT
    // ======================================

    public function mostrarCheckout() {

        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        if (empty($_SESSION['carrito'])) {

            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $carrito = $_SESSION['carrito'];

        require __DIR__ . '/../views/checkout.php';
    }

    // ======================================
    // PROCESAR PAGO
    // ======================================

    public function procesarPago() {

        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        if (empty($_SESSION['carrito'])) {

            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $metodo_pago = $_POST['metodo_pago'] ?? '';
        $numero_tarjeta = $_POST['numero_tarjeta'] ?? '';
        $cvv = $_POST['cvv'] ?? '';

        // Validaciones
        if (
            empty($metodo_pago) ||
            empty($numero_tarjeta) ||
            empty($cvv)
        ) {

            $_SESSION['error'] = "Todos los datos son obligatorios";

            header("Location: index.php?accion=checkout");
            exit;
        }

        // Validar tarjeta de 16 dígitos
        if (strlen($numero_tarjeta) != 16 || !is_numeric($numero_tarjeta)) {

            $_SESSION['error'] = "La tarjeta debe tener 16 dígitos";

            header("Location: index.php?accion=checkout");
            exit;
        }

        // CVV válido
        if ($cvv !== "123") {

            $_SESSION['error'] = "Pago rechazado";

            header("Location: index.php?accion=checkout");
            exit;
        }

        // Crear pedido
        $pedido_id = Pedido::crearPedido(
            $_SESSION['usuario']['id'],
            $_SESSION['carrito'],
            $metodo_pago
        );

        if ($pedido_id) {

            $_SESSION['pedido_id'] = $pedido_id;

            unset($_SESSION['carrito']);

            header("Location: index.php?accion=confirmacion");
            exit;
        }

        $_SESSION['error'] = "Error al procesar pedido";

        header("Location: index.php?accion=checkout");
        exit;
    }

    // ======================================
    // CONFIRMACIÓN
    // ======================================

    public function confirmacion() {

        $pedido_id = $_SESSION['pedido_id'] ?? null;

        require __DIR__ . '/../views/confirmacion.php';
    }

    // ======================================
    // HISTORIAL DE PEDIDOS
    // ======================================

    public function misPedidos() {

        $pedidos = Pedido::obtenerPedidosPorUsuario(
            $_SESSION['usuario']['id']
        );

        require __DIR__ . '/../views/pedidos.php';
    }
}

?>