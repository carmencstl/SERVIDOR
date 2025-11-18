<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tabla Bootstrap</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Listado de Alumnos</h5>
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Notas</th>
                                <th scope="col">Media</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $estudiantes = $_SESSION["estudiantes"] ?? [];
                        foreach ($estudiantes as $estudiante) {
                            echo "<tr>";
                            echo "<td>" . ($estudiante["nombre"]) . "</td>";
                            echo "<td>" . (implode(", ", $estudiante["notas"])) . "</td>";
                            echo "<td>" . ($estudiante["media"]) . "</td>";
                            echo "<td>" . ($estudiante["estado"]) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center mt-4"><a href="index.php">Volver al inicio</a></div>
        </div>
    </div>
</main>
</body>
</html>

