<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Tabla de multiplicar</title>
</head>
<body>
<table>
    <?php
    for ($i = 0; $i <= 10; $i++) {
        echo "<tr><td>{$_POST["numero"]} x {$i} = </td>";
        echo "<td>" . ($_POST["numero"] * $i) . "</td>";
    }
    ?>

</table>

</body>
</html>
