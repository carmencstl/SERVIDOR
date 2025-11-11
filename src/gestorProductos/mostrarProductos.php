<?php
require_once "libreria/libreria.php";
session_start();

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mostrar productoss</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Listado de productos</h5>
                    <form method="post"  class="form">
                        <select name="filtro" class="form-control">
                            <option value="">Filtrar</option>
                            <option value="a-z">a-z</option>
                            <option value="z-a">z-a</option>
                            <option value="Menor a mayor precio">Menor a mayor precio</option>
                            <option value="Mayor a menor precio">Mayor a menor precio</option>
                            <option value="Aceites">Aceites</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-4 mb-4">Filtrar</button>
                    </form>
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
                             <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Precio Unitario</th>
                                 <th scope="col">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                $_SESSION["productos"] = $_SESSION["productos"] ?? [];

                                if (!empty($_POST["filtro"])) {
                                    $productos_mostrados = ordenar($_POST["filtro"], $_SESSION["productos"]);
                                } else {
                                    $productos_mostrados = $_SESSION["productos"];
                                }

                                foreach ($productos_mostrados as $producto) {
                                    echo "<tr>";
                                    echo "<td>{$producto["nombre"]}</td>";
                                    echo "<td>{$producto["categoria"]}</td>";
                                    echo "<td>{$producto["precio"]}</td>";
                                    echo "<td>{$producto["stock"]}</td>";
                                    echo "</tr>";
                                }

                                ?>
                        </tbody>
                    </table>
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

