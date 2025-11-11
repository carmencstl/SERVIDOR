<?php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
    >
    <title>Eliminar estudiante</title>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Eliminar Estudiante</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Introduce el nombre del estudiante a eliminar</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Carmen" required>
                        </div>
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Eliminar estudiante
                            </button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST["nombre"])) {
                        $estudiantes = $_SESSION["estudiantes"] ?? [];
                        $nombre = trim($_POST["nombre"]);
                        if (isset($estudiantes[$nombre])) {
                            unset($estudiantes[$nombre]);
                            $_SESSION["estudiantes"] = $estudiantes;
                            echo '<div class="alert alert-success">Estudiante eliminado correctamente.</div>';
                        } else {
                            echo '<div class="alert alert-warning">No se encontró un estudiante con ese nombre.</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mb-3"><a href="index.php">Volver al inicio </a></div>
</body>
</html>
