<?php

$total = 0;

foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Finalizar compra</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
}

.checkout-card{
    border-radius:20px;
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

    <div class="card shadow p-4 checkout-card">

        <h1 class="text-center mb-4">
            💳 Finalizar compra
        </h1>

        <a href="index.php?accion=ver_carrito"
           class="btn btn-secondary mb-4">
           ← Regresar al carrito
        </a>

        <div class="table-responsive">

            <table class="table table-bordered text-center align-middle">

                <thead class="table-dark">

                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($carrito as $item): ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($item['nombre']); ?>
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

                        <td colspan="3">
                            <strong>Total</strong>
                        </td>

                        <td>
                            <strong>
                                $<?php echo number_format($total,2); ?>
                            </strong>
                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

        <?php if (isset($_SESSION['error'])): ?>

            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>

        <?php endif; ?>

        <!-- FORMULARIO -->
        <form action="index.php?accion=procesar_pago" method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Nombre completo
                    </label>

                    <input type="text"
                           name="nombre_completo"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Método de pago
                    </label>

                    <select name="metodo_pago"
                            class="form-select"
                            required>

                        <option value="">Seleccione</option>

                        <option value="Tarjeta de crédito">
                            Tarjeta de crédito
                        </option>

                        <option value="Tarjeta de débito">
                            Tarjeta de débito
                        </option>

                    </select>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Número de tarjeta
                </label>

                <input type="text"
                       name="numero_tarjeta"
                       maxlength="16"
                       minlength="16"
                       class="form-control"
                       placeholder="1234123412341234"
                       required>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Mes de vencimiento
                    </label>

                    <select name="mes"
                            class="form-select"
                            required>

                        <option value="">Mes</option>

                        <?php for($i=1; $i<=12; $i++): ?>

                            <option value="<?php echo $i; ?>">
                                <?php echo str_pad($i,2,"0",STR_PAD_LEFT); ?>
                            </option>

                        <?php endfor; ?>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Año de vencimiento
                    </label>

                    <select name="anio"
                            class="form-select"
                            required>

                        <option value="">Año</option>

                        <?php for($i=date('Y'); $i<=date('Y')+10; $i++): ?>

                            <option value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </option>

                        <?php endfor; ?>

                    </select>

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    CVV
                </label>

                <input type="password"
                       name="cvv"
                       maxlength="3"
                       class="form-control"
                       placeholder="***"
                       required>

            </div>

            <button type="submit"
                    class="btn btn-success w-100">

                Pagar ahora 💳

            </button>

        </form>

    </div>

</div>

</body>
</html>