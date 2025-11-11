<?php
session_start();

$productosSeleccionados = $_POST["producto"] ?? [];
$_SESSION["productos"] =  $_SESSION["productos"] ?? [];


$_SESSION["productos"] = array_values(array_filter($_SESSION["productos"], function ($producto) use ($productosSeleccionados) {
    return !in_array($producto["nombre"], $productosSeleccionados);
}));

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Borrar un producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Elige que productos quieres borrar</h5>
                    <form method="post">
                        <div class="form-check mb-3">
                            <?php

                            foreach ($_SESSION["productos"] as $producto) {
                                echo '<div class="form-check mb-2">';
                                echo '<input class="form-check-input" type="checkbox" value="' . $producto["nombre"] . '" name="producto[]">';
                                echo '<label class="form-check-label">' . ($producto["nombre"]) . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Borrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <a href="index.php">Volver al inicio</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>