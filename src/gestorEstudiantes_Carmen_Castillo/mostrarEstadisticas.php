<?php
session_start();

if (!isset($_SESSION["estudiantes"])) {
    $_SESSION["estudiantes"] = [
        "Carmen" => ["7", "8", "9"],
        "Luis"   => ["4", "5", "6"],
        "Ana"    => ["9", "10", "8"],
        "Pepe"   => ["3", "4", "5"],
        "Laura"  => ["10", "9", "10"]
    ];
}

$estudiantes = $_SESSION["estudiantes"];
$numeroEstudiante = count($estudiantes);

$suma = 0;
$aprobados = 0;
$suspensos = 0;

foreach ($estudiantes as $nombre => $notas) {
    $notasNumericas = array_map('floatval', $notas);

    $mediaEstudiante = array_sum($notasNumericas) / count($notasNumericas);

    $suma += $mediaEstudiante;
    if ($mediaEstudiante >= 5) {
        $aprobados++;
    } else {
        $suspensos++;
    }
}

$mediaCurso = $suma / $numeroEstudiante;
$porcentajeAprobados = ($aprobados / $numeroEstudiante) * 100;
$porcentajeSuspensos = ($suspensos / $numeroEstudiante) * 100;
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
    <title>Mostrar estadísticas</title>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body text-center">
                    <h3 class="mb-4">Estadísticas del curso</h3>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Nota media del curso</th>
                            <td><?= number_format($mediaCurso, 2) ?></td>
                        </tr>
                        <tr>
                            <th>Porcentaje de aprobados</th>
                            <td><?= number_format($porcentajeAprobados, 2) ?>%</td>
                        </tr>
                        <tr>
                            <th>Porcentaje de suspensos</th>
                            <td><?= number_format($porcentajeSuspensos, 2) ?>%</td>
                        </tr>
                    </table>

                    <a href="index.php" class="btn btn-primary mt-3">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
