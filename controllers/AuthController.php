<?php
/*
|--------------------------------------------------------------------------
| CONTROLLER: AuthController
|--------------------------------------------------------------------------
| Este controlador administra todo el proceso de autenticación
| de usuarios dentro del sistema.
|
| Funciones principales:
| - Mostrar formularios de login y registro
| - Registrar nuevos usuarios
| - Validar inicio de sesión
| - Cerrar sesión
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    /*
    |--------------------------------------------------------------------------
    | mostrarLogin()
    |--------------------------------------------------------------------------
    | Carga la vista login.php
    |
    | Esta vista permite al usuario:
    | - ingresar correo
    | - ingresar contraseña
    | - iniciar sesión
    |--------------------------------------------------------------------------
    */
    public function mostrarLogin() {
        require __DIR__ . '/../views/login.php';
    }

    /*
    |--------------------------------------------------------------------------
    | mostrarRegistro()
    |--------------------------------------------------------------------------
    | Carga la vista registro.php
    |
    | Esta vista permite:
    | - registrar nuevos usuarios
    | - capturar nombre, correo y contraseña
    |--------------------------------------------------------------------------
    */
    public function mostrarRegistro() {
        require __DIR__ . '/../views/registro.php';
    }

    /*
    |--------------------------------------------------------------------------
    | registrar()
    |--------------------------------------------------------------------------
    | Procesa el registro de un nuevo usuario.
    |
    | Pasos realizados:
    | 1. Inicia sesión PHP
    | 2. Obtiene datos enviados desde el formulario
    | 3. Valida campos vacíos
    | 4. Envía datos al modelo Usuario
    | 5. Muestra mensaje de éxito
    |--------------------------------------------------------------------------
    */
    public function registrar() {

        // Inicia sesión
        session_start();

        // Obtiene datos del formulario
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validación básica
        if (empty($nombre) || empty($email) || empty($password)) {

            $_SESSION['error'] = "Todos los campos son obligatorios";

            header("Location: index.php?accion=registro");
            exit;
        }

        // Registra usuario en la base de datos
        Usuario::registrar($nombre, $email, $password);

        // Mensaje de confirmación
        $_SESSION['mensaje'] = "Usuario registrado correctamente";

        // Redirección al login
        header("Location: index.php?accion=login");
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | login()
    |--------------------------------------------------------------------------
    | Valida el acceso de un usuario.
    |
    | Pasos realizados:
    | 1. Obtiene correo y contraseña
    | 2. Busca usuario por email
    | 3. Verifica contraseña usando password_verify()
    | 4. Guarda datos en sesión
    | 5. Redirige al catálogo
    |--------------------------------------------------------------------------
    */
    public function login() {

        // Inicia sesión
        session_start();

        // Datos del formulario
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Busca usuario en la BD
        $usuario = Usuario::buscarPorEmail($email);

        /*
        |--------------------------------------------------------------------------
        | Validación de contraseña
        |--------------------------------------------------------------------------
        | password_verify compara:
        | - contraseña escrita por el usuario
        | - contraseña cifrada almacenada en la BD
        |--------------------------------------------------------------------------
        */
        if ($usuario && password_verify($password, $usuario['password'])) {

            // Guarda información del usuario en sesión
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol']
            ];

            // Redirección al catálogo principal
            header("Location: index.php");
            exit;
        }

        // Error de autenticación
        $_SESSION['error'] = "Correo o contraseña incorrectos";

        header("Location: index.php?accion=login");
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | logout()
    |--------------------------------------------------------------------------
    | Cierra la sesión del usuario actual.
    |
    | Pasos:
    | - inicia sesión
    | - destruye la sesión activa
    | - redirige al login
    |--------------------------------------------------------------------------
    */
    public function logout() {

        // Inicia sesión
        session_start();

        // Elimina datos de sesión
        session_destroy();

        // Redirección al login
        header("Location: index.php?accion=login");
        exit;
    }
}
?>