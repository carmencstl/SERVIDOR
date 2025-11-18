<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Array de numeros</title>
</head>
<body>
</body>
</html>

<div class="container">
    <?php

        $numeros = [];
        $pares = [];
        $impares = [];

        for ($i = 0; $i < 20; $i++) {
            $numeros[] = rand(0, 100);
            if($numeros[$i] % 2 == 0){
                $pares[] = $numeros[$i];
            }
            else{
                $impares[] = $numeros[$i];
            }
        }
    echo "<table class='table'>";

        echo "<tr>";
            echo "<td>Numeros desordenados: " . implode(", ", $numeros) . "</td>";
        echo "</tr>";

    $numeros = array_merge($pares, $impares);

        echo "<tr>";
            echo "<td>Numeros ordenados: " . implode(", ", $numeros) . "</td>";
        echo "</tr>";

    echo "</table>";

    ?>
</div>