
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width:400px;">
        <div class="card-body">

            <h4 class="text-center mb-3">Registro</h4>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="index.php?accion=guardar_usuario" method="POST">

                <input type="text" name="nombre" class="form-control mb-3" placeholder="Nombre" required>

                <input type="email" name="email" class="form-control mb-3" placeholder="Correo" required>

                <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>

                <button class="btn btn-success w-100">Registrarse</button>

            </form>

            <p class="text-center mt-3">
                <a href="index.php?accion=login">Ya tengo cuenta</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>