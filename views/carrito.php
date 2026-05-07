<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito de Compras</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<header class="bg-white py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">

        <img src="/ECOMMERCE/img/logotecnm.png" style="height:60px;">

        <h4 class="m-0 text-primary">
            <b>Carrito de Compras</b>
        </h4>

        <img src="/ECOMMERCE/img/logoitp.png" style="height:60px;">

    </div>
</header>

<div class="container my-5">

    <a href="/ECOMMERCE/index.php"
       class="btn btn-secondary mb-4">

        ← Volver al catálogo

    </a>

    <?php if(empty($carrito)): ?>

        <div class="alert alert-info text-center">
            El carrito está vacío 🛒
        </div>

    <?php else: ?>

        <div class="card shadow-sm">

            <div class="card-body">

                <table class="table table-bordered text-center align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $total = 0;

                    foreach($carrito as $item):

                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                    ?>

                    <tr>

                        <td>
                            <img src="/ECOMMERCE/<?php echo htmlspecialchars($item['imagen']); ?>"
                                 width="80">
                        </td>

                        <td>
                            <?php echo htmlspecialchars($item['nombre']); ?>
                        </td>

                        <td>
                            $<?php echo number_format($item['precio'],2); ?>
                        </td>

                        <td>

                            <div class="d-flex justify-content-center align-items-center gap-2">

                                <!-- RESTAR -->
                                <a href="/ECOMMERCE/index.php?accion=restar_cantidad&id=<?php echo $item['id']; ?>"
                                   class="btn btn-outline-danger btn-sm">

                                    -

                                </a>

                                <strong>
                                    <?php echo $item['cantidad']; ?>
                                </strong>

                                <!-- SUMAR -->
                                <a href="/ECOMMERCE/index.php?accion=sumar_cantidad&id=<?php echo $item['id']; ?>"
                                   class="btn btn-outline-success btn-sm">

                                    +

                                </a>

                            </div>

                        </td>

                        <td>
                            $<?php echo number_format($subtotal,2); ?>
                        </td>

                        <td>

                            <a href="/ECOMMERCE/index.php?accion=eliminar_carrito&id=<?php echo $item['id']; ?>"
                               class="btn btn-danger btn-sm">

                                Eliminar

                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                    </tbody>

                    <tfoot>

                        <tr>

                            <td colspan="4">
                                <strong>Total</strong>
                            </td>

                            <td colspan="2">
                                <strong>
                                    $<?php echo number_format($total,2); ?>
                                </strong>
                            </td>

                        </tr>

                    </tfoot>

                </table>

                <div class="d-flex justify-content-end gap-2">

                    <a href="/ECOMMERCE/index.php?accion=vaciar_carrito"
                       class="btn btn-warning">

                        Vaciar carrito

                    </a>

                    <a href="/ECOMMERCE/index.php?accion=checkout"
                       class="btn btn-success">

                        Proceder al pago 💳

                    </a>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>

</body>
</html>