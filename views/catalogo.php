<?php
// Iniciar sesión solo si no existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TecToys Shop</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* =========================
   ESTILOS GENERALES
========================= */
body{
    background-color:#f8f9fa;
}

/* =========================
   HEADER TECNM
========================= */
.header-tecnm{
    background:white;
    border-bottom:3px solid #0d6efd;
}

/* =========================
   NAVBAR
========================= */
.navbar-custom{
    background:#ffffff;
    border-top:2px solid #0d6efd;
    border-bottom:2px solid #0d6efd;
}

.navbar-brand{
    font-size:1.8rem;
    font-weight:bold;
    color:#0d6efd !important;
}

.logo-navbar{
    width:90px;
    height:90px;
    object-fit:contain;
    margin-right:10px;
}

/* =========================
   TEXTO ANIMADO
========================= */
.texto-tienda{
    font-size:3rem;
    font-weight:bold;
    text-align:center;
    margin-bottom:30px;

    animation: colores 3s infinite;
}

@keyframes colores{
    0%{ color:#0d6efd; }
    25%{ color:#dc3545; }
    50%{ color:#198754; }
    75%{ color:#ffc107; }
    100%{ color:#6610f2; }
}

/* =========================
   TARJETAS
========================= */
.card{
    border-radius:15px;
    transition:0.3s;
}

.card:hover{
    transform:scale(1.03);
}

.card img{
    height:220px;
    object-fit:contain;
}

.sin-stock{
    opacity:0.6;
    filter:grayscale(100%);
}

/* =========================
   BOTONES
========================= */
.btn{
    border-radius:10px;
}

</style>

</head>

<body>

<!-- =========================
     HEADER TECNM
========================= -->
<header class="header-tecnm py-3 shadow-sm">

    <div class="container d-flex justify-content-between align-items-center">

        <!-- LOGO TECNM -->
        <div style="width:120px;height:70px;
                    display:flex;
                    align-items:center;
                    justify-content:center;">

            <img src="/ECOMMERCE/img/logotecnm.png"
                 style="max-width:100%;max-height:100%;">
        </div>

        <!-- TEXTO -->
        <h5 class="m-0 text-center fw-bold">
            Tecnológico Nacional de México - Campus Pachuca
        </h5>

        <!-- LOGO ITP -->
        <div style="width:120px;height:70px;
                    display:flex;
                    align-items:center;
                    justify-content:center;">

            <img src="/ECOMMERCE/img/logoitp.png"
                 style="max-width:100%;max-height:100%;">
        </div>

    </div>

</header>

<!-- =========================
     NAVBAR
========================= -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom shadow-sm">

    <div class="container">

        <!-- LOGO + TITULO -->
        <a class="navbar-brand d-flex align-items-center" href="#">

            <img src="/ECOMMERCE/img/logo.png"
                 class="logo-navbar">

            TecToys Shop
        </a>

        <!-- BOTON RESPONSIVE -->
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuNavbar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse justify-content-end"
             id="menuNavbar">

            <div class="d-flex gap-2 flex-wrap align-items-center">

                <?php if(isset($_SESSION['usuario'])): ?>

                    <!-- BIENVENIDA -->
                    <span class="fw-bold text-dark">
                        Bienvenido,
                        <?php echo $_SESSION['usuario']['nombre']; ?>
                    </span>

                    <!-- CARRITO -->
                    <a href="/ECOMMERCE/index.php?accion=ver_carrito"
                       class="btn btn-success btn-sm">

                        🛒 Carrito
                    </a>

                    <!-- PEDIDOS -->
                    <a href="/ECOMMERCE/index.php?accion=mis_pedidos"
                       class="btn btn-warning btn-sm">

                        📦 Pedidos
                    </a>

                    <!-- LOGOUT -->
                    <a href="/ECOMMERCE/index.php?accion=logout"
                       class="btn btn-danger btn-sm">

                        Cerrar sesión
                    </a>

                <?php else: ?>

                    <!-- LOGIN -->
                    <a href="/ECOMMERCE/index.php?accion=login"
                       class="btn btn-primary btn-sm">

                        Iniciar sesión
                    </a>

                    <!-- REGISTRO -->
                    <a href="/ECOMMERCE/index.php?accion=registro"
                       class="btn btn-dark btn-sm">

                        Registrarse
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</nav>

<!-- =========================
     CONTENIDO
========================= -->
<div class="container my-5">

    <!-- TEXTO ANIMADO -->
    <div class="texto-tienda">
        TIENDA
    </div>

    <!-- PRODUCTOS -->
    <div class="row g-4">

        <?php foreach ($productos as $producto): ?>

        <div class="col-md-4">

            <div class="card shadow-sm h-100 text-center
                <?php echo ($producto['stock'] <= 0)
                    ? 'sin-stock'
                    : ''; ?>">

                <!-- IMAGEN -->
                <img src="/ECOMMERCE/<?php echo htmlspecialchars($producto['imagen']); ?>"
                     class="card-img-top p-3">

                <!-- BODY -->
                <div class="card-body d-flex flex-column">

                    <!-- NOMBRE -->
                    <h5 class="fw-bold">
                        <?php echo htmlspecialchars($producto['nombre']); ?>
                    </h5>

                    <!-- DESCRIPCION -->
                    <p class="text-muted small">
                        <?php echo htmlspecialchars($producto['descripcion']); ?>
                    </p>

                    <!-- PRECIO -->
                    <h4 class="text-primary fw-bold">
                        $<?php echo number_format($producto['precio'],2); ?>
                    </h4>

                    <!-- STOCK -->
                    <p class="small">

                        <?php if($producto['stock'] > 0): ?>

                            <span class="text-success fw-bold">
                                Stock disponible:
                                <?php echo $producto['stock']; ?>
                            </span>

                        <?php else: ?>

                            <span class="text-danger fw-bold">
                                Sin Stock Disponible
                            </span>

                        <?php endif; ?>

                    </p>

                    <!-- BOTON -->
                    <div class="mt-auto">

                        <?php if($producto['stock'] > 0): ?>

                            <?php if(isset($_SESSION['usuario'])): ?>

                                <a href="/ECOMMERCE/index.php?accion=agregar_carrito&id=<?php echo $producto['id']; ?>"
                                   class="btn btn-primary">

                                    Agregar al carrito
                                </a>

                            <?php else: ?>

                                <a href="/ECOMMERCE/index.php?accion=login"
                                   class="btn btn-warning">

                                    Inicia sesión para comprar
                                </a>

                            <?php endif; ?>

                        <?php else: ?>

                            <button class="btn btn-secondary" disabled>
                                Sin stock
                            </button>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>

<!-- =========================
     FOOTER
========================= -->
<footer class="bg-light border-top text-center py-3 mt-5">

    <small>
        Copyright 2026 - TECNM Pachuca -
        Negocios Electrónicos 2 -
        Equipo 1
        (Milton, Alicia Yamileth, Derek Alejandro)
    </small>

</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>