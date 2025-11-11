<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Piramide</title>
</head>
<body>

<div class="container m-3">
    <form method="post">
        <label class="form-label">Introduce la altura de la pirámide</label>
        <input type="number"  name="numero">
        <label class="form-label">Introduce el símbolo para dibujar la pirámide</label>
        <input type="text" name="simbolo">
        <button class="btn btn-outline-dark mt-4">Dibujar</button>
    </form>
</div>

</body>
</html>
<div class="m-5">
<?php
$n = $_POST["numero"];
$simbolo = $_POST["simbolo"];

for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $n - $i; $j++) {
        echo "&nbsp;";
    }
    for ($k = 1; $k <= $i; $k++) {
        echo " $simbolo";
    }
    echo "<br>";
}

?>

</div>