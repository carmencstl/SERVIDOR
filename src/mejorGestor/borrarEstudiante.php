<?php
session_start();

$estudiantes = $_SESSION["estudiantes"] ?? [];
$nombreEliminar = $_POST["nombre"] ?? "";
$eliminado = false;
$formEnviado = false;

if(!empty($nombreEliminar)){
    $formEnviado = true;
}

foreach ($estudiantes as $index => $est) {
    if (!$eliminado && $est["nombre"] === $nombreEliminar) {
        unset($_SESSION["estudiantes"][$index]);
        $eliminado = true;
    }
}
$_SESSION["estudiantes"] = array_values($_SESSION["estudiantes"]);
$mensaje = $eliminado ? "El alumno ha sdo eliminado correctamente" : "No se ha podido eliminar al alumno";

?>

</pre>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Borrar estudiante</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Introduce el nombre del alumno que quieras borrar</h5>
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required autofocus>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Borrar</button>
                        </div>
                    </form>
                    <div class="row justify-content-center mt-4"><a href="index.php">Volver al inicio</a></div>
                </div>
            </div>
            <div>
                <?php if ($formEnviado): ?>
                    <div class="row justify-content-center mt-4 alert alert-primary"><?= $mensaje ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>
