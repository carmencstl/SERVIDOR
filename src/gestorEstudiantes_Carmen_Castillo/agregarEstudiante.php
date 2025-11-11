<?php
session_start();

//Aqui compruebo que existe y sino lo crea vacio

if (!isset($_SESSION["estudiantes"])) {
    $_SESSION["estudiantes"] = [];
}

//Lo mismo con los nombres y las notas
    $nombreAlumno = $_POST["nombre"] ?? '';
    $notasString = $_POST["notas"] ?? '';

    //Si estan vacio muestro un aviso
    if ($nombreAlumno === '' || $notasString === '') {
        $mensaje = "Por favor completa todos los campos.";
        //Sino separo las notas de las comas para poder trabajar con numeros

    } else {
        $notas = explode(",", $notasString);
        $notasAlumno = [];
        $valido = true;

        //Recorro las notas y compruebo si son validas, si las son las guardo en un array
        foreach ($notas as $nota) {
            $nota = (int)trim($nota);
            if ($nota < 0 || $nota > 10) {
                $valido = false;
            }
            $notasAlumno[] = $nota;
        }

        //Si todas las notas son validas las guardo
        if ($valido) {
            $_SESSION["estudiantes"][$nombreAlumno] = $notasAlumno;
            $mensaje = "Estudiante agregado correctamente.";
            //Si no, muestro un mensaje y no guardo nada
        } else {
            $mensaje = "Las notas no son válidas.";
        }
    }
    //Guardo en estudiantes
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
