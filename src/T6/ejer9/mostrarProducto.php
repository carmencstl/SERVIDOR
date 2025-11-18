<?php

require_once "Producto.php";
session_start();

    $_SESSION["productos"] = $_SESSION["productos"] ?? [];


    if(!empty($_POST)){
        $producto = new Producto($_POST["nombre"], $_POST["precio"], $_POST["categoria"]);
        array_push($_SESSION["productos"], $producto);
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light p-4">
  <div class="container">
    <table class="table table-striped table-bordered">
      <thead class="table-primary">
        <tr>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Categoria</th>
        </tr>
      </thead>
      <tbody>
      <?php

        if(!empty($_SESSION["productos"])){
            foreach ($_SESSION["productos"] as $producto) {
                echo "<tr>";
                echo "<td>{$producto->getNombre()}</td>";
                echo "<td>{$producto->getPrecio()}</td>";
                echo "<td>{$producto->getCategoria()}</td>";
                echo "</tr>";
            }
        }
      ?>
      </tbody>
    </table>
  </div>
</body>
</html>

