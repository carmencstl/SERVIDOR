<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Invertir numero</title>
</head>
<body>

<div class="container m-3">
    <form method="post">
        <label class="form-label">Introduce el numero a invertir</label>
        <input type="number"  name="numero">
        <button class="btn btn-outline-dark mt-4">Invertir</button>
    </form>
</div>

</body>
</html>
<?php


    $numero = $_POST["numero"];

        $digitos = str_split((string)$numero);
        $digitos = array_reverse($digitos);
        $digitos = implode("", $digitos);
        echo "Número original: " . $numero . "<br>";
        echo "Número invertido: " . $digitos;
