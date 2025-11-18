<?php
session_start();

// Ejemplo temporal (elimina esto si ya tienes $_SESSION["estudiantes"] cargado)
if (!isset($_SESSION["estudiantes"])) {
    $_SESSION["estudiantes"] = [
        "Carmen" => [0, 1, 2],
        "Luis"   => [3, 4, 5],
        "Ana"    => [6, 7, 8]
    ];
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
    <title>Buscar Estudiante</title>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Buscar Estudiante</h3>

                    <form method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Introduce el nombre del estudiante</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Carmen" required>
                        </div>
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Buscar estudiante
                            </button>
                        </div>
                    </form>

                    <?php

                        $estudiantes = $_SESSION["estudiantes"];
                        $nombre = trim($_POST["nombre"]);

                        echo '<div class="mt-4">';
                        if (array_key_exists($nombre, $estudiantes)) {
                            echo '<table class="table table-bordered table-striped text-center">';
                            echo '<thead class="table-dark"><tr><th>Estudiante</th><th>Notas</th></tr></thead>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' . $nombre . '</td>';
                            echo '<td>' . implode(", ", $estudiantes[$nombre]) . '</td>';
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<div class="alert alert-danger text-center">';
                            echo '❌ ' . $nombre . ' no está en la lista.';
                            echo '</div>';
                        }
                        echo '</div>';

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
            <div class="text-center mb-3"><a href="index.php">Volver al inicio </a></div>
</body>
</html>
