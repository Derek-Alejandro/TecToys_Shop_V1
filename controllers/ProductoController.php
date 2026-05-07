<?php
/*
|--------------------------------------------------------------------------
| CONTROLLER: ProductoController
|--------------------------------------------------------------------------
| Este controlador administra la lógica relacionada con los productos
| del catálogo del sistema e-commerce.
|
| Función principal:
| - Obtener productos desde el modelo
| - Enviar información a la vista catálogo
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../models/producto.php';

class ProductoController {

    /*
    |--------------------------------------------------------------------------
    | mostrarCatalogo()
    |--------------------------------------------------------------------------
    | Este método:
    | 1. Solicita al modelo todos los productos disponibles
    | 2. Guarda la información en la variable $productos
    | 3. Envía los datos a la vista catalogo.php
    |
    | La vista será la encargada de:
    | - mostrar imágenes
    | - mostrar precios
    | - mostrar stock
    | - permitir agregar productos al carrito
    |--------------------------------------------------------------------------
    */
    public function mostrarCatalogo() {

        // Obtiene todos los productos desde el modelo
        $productos = Producto::obtenerTodos();

        /*
        |--------------------------------------------------------------------------
        | Enviar datos a la vista
        |--------------------------------------------------------------------------
        | La variable $productos queda disponible dentro de:
        | views/catalogo.php
        |--------------------------------------------------------------------------
        */
        require __DIR__ . '/../views/catalogo.php';
    }
}
?>