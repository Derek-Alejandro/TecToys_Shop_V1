<?php

// ======================================
// CONTROLADORES PRINCIPALES
// ======================================

require_once 'controllers/ProductoController.php';
require_once 'controllers/CarritoController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CheckoutController.php';

// ======================================
// INICIAR SESIÓN GLOBAL
// ======================================

session_start();

// ======================================
// ACCIÓN SOLICITADA
// ======================================

$accion = $_GET['accion'] ?? 'catalogo';

// ======================================
// ENRUTADOR PRINCIPAL
// ======================================

switch ($accion) {

    // ======================================
    // CATÁLOGO
    // ======================================

    case 'catalogo':

        $controller = new ProductoController();
        $controller->mostrarCatalogo();

    break;

    // ======================================
    // AUTENTICACIÓN
    // ======================================

    case 'login':

        (new AuthController())->mostrarLogin();

    break;

    case 'registro':

        (new AuthController())->mostrarRegistro();

    break;

    case 'guardar_usuario':

        (new AuthController())->registrar();

    break;

    case 'validar_login':

        (new AuthController())->login();

    break;

    case 'logout':

        (new AuthController())->logout();

    break;

    // ======================================
    // CARRITO PROTEGIDO
    // ======================================

    case 'agregar_carrito':
    case 'ver_carrito':
    case 'eliminar_carrito':
    case 'vaciar_carrito':
    case 'sumar_cantidad':
    case 'restar_cantidad':

        // Validar sesión activa
        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        $controller = new CarritoController();

        // Agregar producto
        if ($accion === 'agregar_carrito') {

            $controller->agregar($_GET['id'] ?? null);
        }

        // Ver carrito
        elseif ($accion === 'ver_carrito') {

            $controller->verCarrito();
        }

        // Eliminar producto
        elseif ($accion === 'eliminar_carrito') {

            $controller->eliminar($_GET['id'] ?? null);
        }

        // Vaciar carrito
        elseif ($accion === 'vaciar_carrito') {

            $controller->vaciar();
        }

        // Sumar cantidad
        elseif ($accion === 'sumar_cantidad') {

            $controller->sumarCantidad($_GET['id'] ?? null);
        }

        // Restar cantidad
        elseif ($accion === 'restar_cantidad') {

            $controller->restarCantidad($_GET['id'] ?? null);
        }

    break;

    // ======================================
    // CHECKOUT
    // ======================================

    case 'checkout':

        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        (new CheckoutController())->mostrarCheckout();

    break;

    // ======================================
    // PROCESAR PAGO
    // ======================================

    case 'procesar_pago':

        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        (new CheckoutController())->procesarPago();

    break;

    // ======================================
    // CONFIRMACIÓN
    // ======================================

    case 'confirmacion':

        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        (new CheckoutController())->confirmacion();

    break;

    // ======================================
    // PEDIDOS DEL USUARIO
    // ======================================

    case 'mis_pedidos':

        if (!isset($_SESSION['usuario'])) {

            header("Location: index.php?accion=login");
            exit;
        }

        (new CheckoutController())->misPedidos();

    break;

    // ======================================
    // DEFAULT
    // ======================================

    default:

        (new ProductoController())->mostrarCatalogo();

    break;
}

?>