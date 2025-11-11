<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <?php
    //echo "<pre>".print_r($_GET, true)."</pre>";
    //die(); Para el proceso hasta este punto
    $fecha = date("d/m/Y",strtotime($_GET["fecha"]));
    //echo time(). "<br/>";
    // echo "$fecha <br/>";
    echo "Nombre: {$_GET["nombre"]}<br/>";
    echo "Fecha: {$fecha}<br/>";
    echo "Nombre: {$_GET["color"]}<br/>";

    //echo "Aficiones:...";
    echo "Aficiones: " . implode(", ",$_GET["aficiones"]) . "<br/>";
    //        foreach ($_GET["aficiones"] as $item) {
    //
    //            echo "$item " ;
    //        }

    ?>





</div>

</body>
</html>