<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Mostrar Estudiantes</title>
</head>
<body>
<?php
$estudiantes = $_SESSION["estudiantes"];
$claves = array_keys($estudiantes);
?>
<div class="container mt-4">
    <h3 class="mb-3">Lista de Estudiantes</h3>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
        <tr>
            <th>Estudiante</th>
            <th>Notas</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($claves as $estudiante): ?>
            <tr>
                <td><?= $estudiante ?></td>
                <td><?= implode(", ", $estudiantes[$estudiante]) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="text-center mb-3"><a href="index.php">Volver al inicio </a></div>
</div>
</body>
</html>
