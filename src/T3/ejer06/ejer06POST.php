<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambio de divisas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php
            $a = $_POST["A"];
            $b = $_POST["B"];
            $c = $_POST["C"];

        $raizc = ($b * $b) - (4 * $a * $c);

             if ($raizc > 0) {
            $x1 = (-$b + sqrt($raizc)) / (2 * $a);
            $x2 = (-$b - sqrt($raizc)) / (2 * $a);
            echo "La ecuación tiene dos soluciones reales:<br>";
            echo "x+ = " . $x1 . "<br>";
            echo "x- = " . $x2 . "<br>";
        } elseif ($raizc == 0) {
            $x = -$b / (2 * $a);
            echo "La ecuación tiene una única solución real:<br>";
            echo "x = " . $x . "<br>";
        } else {
            $parteReal = -$b / (2 * $a);
            $parteImaginaria = sqrt(-$raizc) / (2 * $a);
            echo "La ecuación tiene soluciones complejas:<br>";
            echo "x1 = " . $parteReal . " + " . $parteImaginaria . "i<br>";
            echo "x2 = " . $parteReal . " - " . $parteImaginaria . "i<br>";
        }
    ?>
</div>

</body>
</html>

