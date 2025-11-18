<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Posicion del numero</title>
</head>
<body>
<div class="container m-3">
    <form method="post">
        <label class="form-label">Introduce un numero</label>
        <input type="number"  name="numero">
        <label class="form-label">Introduce el digito que quieres buscar</label>
        <input type="number"  name="digito">
        <button class="btn btn-outline-dark mt-4">Buscar digito</button>
    </form>
</div>
</body>
</html>

<div class="container">
    <?php

    $numero = $_POST["numero"];
    $digito = (string)$_POST["digito"];

    $numerosArr = str_split((string)$numero);
    $posiciones = array_keys($numerosArr, $digito);

    echo "El dígito se encuentra en las posiciones: " . implode(", ", $posiciones);
?>
</div>