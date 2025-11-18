<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Array de numeros</title>
</head>
<body>
<div class="container m-3">
    <form method="post">
        <label class="form-label">Introduce 10 numeros</label>
        <input type="number"  name="numero">
        <button class="btn btn-outline-dark mt-4">Mostrar</button>
</div>
</body>
</html>

<div class="container">
    <?php
    $numeros = str_split((string)$_POST["numero"]);

    if (count($numeros) < 10) {
        echo "Debes introducir 10 numeros";
    } else {
        echo "<table class='table'>";

            echo "<tr>";
                for ($i = 0; $i < count($numeros); $i++) {
                    echo "<td>{$i}</td>";

                }
                echo "</tr>";

                echo "<tr>";
                for ($i = 0; $i < count($numeros); $i++) {
                    echo "<td>{$numeros[$i]}</td>";
                }
            echo "</tr>";

        echo "</table>";
    }
    ?>

</div>