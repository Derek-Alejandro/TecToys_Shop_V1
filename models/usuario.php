<?php
/*
|--------------------------------------------------------------------------
| MODELO: Usuario
|--------------------------------------------------------------------------
| Este modelo administra las operaciones relacionadas con usuarios.
|
| Funciones principales:
| - Registrar nuevos clientes
| - Buscar usuarios por correo electrónico
| - Validar acceso al sistema
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/db.php';

class Usuario {

    /*
    |--------------------------------------------------------------------------
    | registrar($nombre, $email, $password)
    |--------------------------------------------------------------------------
    | Registra un nuevo usuario en la base de datos.
    |
    | Antes de guardar la contraseña:
    | - se protege usando password_hash()
    | - esto evita almacenar contraseñas en texto plano
    |
    | Parámetros:
    | - $nombre
    | - $email
    | - $password
    |--------------------------------------------------------------------------
    */
    public static function registrar($nombre, $email, $password) {
        global $conexion;

        // Genera contraseña cifrada/hash
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password) 
                VALUES (:nombre, :email, :password)";

        $stmt = $conexion->prepare($sql);

        // Enlace de parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        // Ejecuta el INSERT
        return $stmt->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | buscarPorEmail($email)
    |--------------------------------------------------------------------------
    | Busca un usuario usando su correo electrónico.
    |
    | Se utiliza principalmente para:
    | - inicio de sesión
    | - validación de credenciales
    |
    | Solo permite usuarios con estado = activo
    |--------------------------------------------------------------------------
    */
    public static function buscarPorEmail($email) {
        global $conexion;

        $sql = "SELECT * FROM usuarios 
                WHERE email = :email AND estado = 'activo'";

        $stmt = $conexion->prepare($sql);

        // Enlace del correo electrónico
        $stmt->bindParam(':email', $email);

        // Ejecuta consulta
        $stmt->execute();

        // Retorna información del usuario
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>