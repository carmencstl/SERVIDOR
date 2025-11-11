<?php
require_once "./libreria/libreria.php";

session_start();

$mensaje = "";
$formEnviado = false;

if (isset($_POST["nombre"]) && isset($_POST["notas"])) {
    $formEnviado = true;

    $estudiante = $_POST["nombre"];
    $notas = $_POST["notas"];

    if (!isset($_SESSION["estudiantes"])) {
        $_SESSION["estudiantes"] = [];
    }

    $notas = explode(",", $notas);
    $estado = calcularMedia($notas) >= 5 ? "aprobado" : "suspenso";

    if (comprobarNotas($notas)) {
        $estudianteNuevo = [
            "nombre" => $estudiante,
            "notas" => $notas,
            "media" => calcularMedia($notas),
            "estado" => $estado
        ];
        array_push($_SESSION["estudiantes"], $estudianteNuevo);
        $mensaje = "Estudiante agregado al sistema";
    } else {
        $mensaje = "Las notas no son válidas";
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Agregar estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Agregar un nuevo estudiante</h5>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del estudiante" autofocus required>
                        </div>
                        <div class="mb-3">
                            <label for="notas" class="form-label">Introduce al menos 3 notas:</label>
                            <textarea id="notas" name="notas" rows="6" class="form-control" placeholder="Ej. 9, 5.6, 10" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php if ($formEnviado): ?>
                <div class="row justify-content-center mt-4 alert alert-primary"><?= $mensaje ?></div>
            <?php endif; ?>

            <div class="row justify-content-center mt-4"><a href="index.php">Volver al inicio</a></div>
        </div>
    </div>
</main>
</body>
</html>
