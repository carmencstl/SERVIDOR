<?php
require_once "libreria/libreria.php";
session_start();

$_SESSION["productos"] = $_SESSION["productos"] ?? [];

$totalProductos = count($_SESSION["productos"]);
$categoriaMayor = mayorCategoria($_SESSION);





?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estadisticas</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Listado de Usuarios</h5>
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="col">N total de productos</th>
                                <th class="col">Categoría con más productos</th>
                                <th class="col">Producto con menor stock</th>
                                <th class="col">Producto con más stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?= $totalProductos ?>
                                </td>
                                <td><?= $categoriaMayor ?></td>
                                <td>juan@example.com</td>
                                <td>Administrador</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>

