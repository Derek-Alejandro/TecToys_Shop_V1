<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pedido = $_SESSION['ultimo_pedido'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Compra confirmada</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f4f4;
}

.card-confirmacion{
    border-radius:20px;
}

.producto-img{
    width:100px;
    height:100px;
    object-fit:contain;
}

</style>

</head>

<body>

<!-- HEADER -->
<header class="bg-white text-black py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">

        <div style="width:120px;height:65px;display:flex;align-items:center;justify-content:center;">
            <img src="/ECOMMERCE/img/logotecnm.png" style="max-width:100%;max-height:100%;">
        </div>

        <h5 class="m-0 text-center">
            <b>Tecnológico Nacional de México - Campus Pachuca</b>
        </h5>

        <div style="width:120px;height:65px;display:flex;align-items:center;justify-content:center;">
            <img src="/ECOMMERCE/img/logoitp.png" style="max-width:100%;max-height:100%;">
        </div>

    </div>
</header>

<div class="container my-5">

    <div class="card shadow card-confirmacion p-4">

        <h1 class="text-center text-success mb-3">
            ✅ ¡Compra realizada correctamente!
        </h1>

        <p class="text-center text-muted">
            Tu pedido fue registrado exitosamente.
        </p>

        <?php if (!empty($pedido)): ?>

            <div class="alert alert-success text-center">
                <strong>Pedido #<?php echo $pedido['id']; ?></strong><br>
                Fecha:
                <?php echo $pedido['fecha']; ?>
            </div>

            <h4 class="mb-4">Resumen de compra</h4>

            <div class="table-responsive">

                <table class="table table-bordered bg-white align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($pedido['productos'] as $item): ?>

                        <tr>

                            <td>
                                <img src="/ECOMMERCE/<?php echo $item['imagen']; ?>"
                                     class="producto-img">
                            </td>

                            <td>
                                <?php echo $item['nombre']; ?>
                            </td>

                            <td>
                                <?php echo $item['cantidad']; ?>
                            </td>

                            <td>
                                $<?php echo number_format($item['precio'],2); ?>
                            </td>

                            <td>
                                $
                                <?php
                                echo number_format(
                                    $item['precio'] * $item['cantidad'],
                                    2
                                );
                                ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                    <tfoot>

                        <tr>

                            <td colspan="4">
                                <strong>Total pagado</strong>
                            </td>

                            <td>
                                <strong>
                                    $<?php echo number_format($pedido['total'],2); ?>
                                </strong>
                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

            <div class="alert alert-info mt-4">
                📦 Puedes revisar este pedido en la sección
                <strong>Mis Pedidos</strong>.
            </div>

        <?php endif; ?>

        <div class="d-flex justify-content-center gap-3 mt-4">

            <a href="/ECOMMERCE/index.php"
               class="btn btn-primary">
               Volver al catálogo
            </a>

            <a href="/ECOMMERCE/index.php?accion=mis_pedidos"
               class="btn btn-success">
               Ver mis pedidos
            </a>

        </div>

    </div>

</div>

</body>
</html>