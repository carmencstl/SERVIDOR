<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    echo "<pre>" .print_r($_POST, true) . "</pre>";
    // Fecha
    $fecha = date("d/m/Y",strtotime($_POST["fecha"]));
    $color = $_POST["color"];
    ?>

    Nombre: <?= $_POST["nombre"] ?><br/>
    Fecha de nacimiento: <?= $fecha ?><br/>
    Color: <span class="badge" style="color:#000; background-color: <?= $color ?>; "><?= $color ?></span>



</div>

</body>
</html>