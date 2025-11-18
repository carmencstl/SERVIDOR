<?php
require_once "./libreria/libreria.php";
session_start();

$estudiantes = $_SESSION["estudiantes"] ?? [];
$medias = array_column($estudiantes, "media");
$mediaTotal = calcularMedia($medias);
$nEstudiantes = count($estudiantes);
$aprobados = 0;
$suspensos = 0;

foreach ($medias as $media){
    if($media >= 5){
        $aprobados++;
    }
    else{
        $suspensos++;
    }
}

$aprobados = $aprobados * 100 / $nEstudiantes;
$suspensos = $suspensos * 100 / $nEstudiantes;

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estadisticas</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Estadisticas</h5>
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Numero de alumnos</th>
                                <th scope="col">Media total</th>
                                <th scope="col">Tasa de aprobados</th>
                                <th scope="col">Tasa de suspensos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                 <?php
                                echo "<tr>";
                                echo "<td>" . $nEstudiantes . "</td>";
                                echo "<td>" . $mediaTotal . "</td>";
                                echo "<td>" . $aprobados . "%" . "</td>";
                                 echo "<td>" . $suspensos . "%" . "</td>";
                                echo "</tr>";
                                 ?>
                            </tr>
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

