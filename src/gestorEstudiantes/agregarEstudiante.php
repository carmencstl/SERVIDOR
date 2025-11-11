<?php
session_start();
if (!isset($_SESSION["estudiantes"])) {
    $_SESSION["estudiantes"] = [];
}

$nombreAlumno = $_POST["nombre"];
$notas = explode(",", $_POST["notas"]);
$notasAlumno = [];
$valido = true;


foreach ($notas as $nota) {
    $nota = (int)trim($nota);
    if ($nota < 0 || $nota > 10) {
        $valido = false;
    }
    $notasAlumno[] = $nota;
}

if ($valido) {
    $_SESSION["estudiantes"][$nombreAlumno] = $notasAlumno;
    $mensaje = "";
} else {
    $mensaje = "Las notas no son válidas";
}

$estudiantes = $_SESSION["estudiantes"];
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Agregar Estudiante</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center mb-4">Agregar Estudiante</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre del alumno</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Introduce mínimo 3 notas del alumno</label>
                            <textarea class="form-control" rows="4" placeholder="Ej: 8, 9.5, 7" required name="notas"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                            <div>
                                <?php if(isset($mensaje)): ?>
                                    <p><?= $mensaje ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                     <div class="text-center mb-3"><a href="index.php">Volver al inicio </a></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
