<?php
session_start();

//Compruebo que la sesion existe y sino la creo vacia
if (!isset($_SESSION["estudiantes"])) {
    $_SESSION["estudiantes"] = [];
}

//Inicializo variables
$mensaje = "";
$nombre = "";
$resultado = "";

//Compruebo que el nombre no este vacio
    $nombre = trim($_POST["nombre"] ?? '');
//Si esta vacio muestro un mensaje de error
    if ($nombre === '') {
        $mensaje = "Por favor, introduce un nombre válido.";
    } else {
        $estudiantes = $_SESSION["estudiantes"];

        //Compruebo que el nombre introducido existe dentro de los estudiantes
        if (array_key_exists($nombre, $estudiantes)) {
            $resultado .= '<div class="mt-4">';
            $resultado .= '<table class="table table-bordered table-striped text-center">';
            $resultado.= '<thead class="table-dark"><tr><th>Estudiante</th><th>Notas</th></tr></thead>';
            $resultado .= '<tbody>';
            $resultado .= '<tr>';
            $resultado .= '<td>' . $nombre . '</td>';
            $resultado .= '<td>' . implode(", ", $estudiantes[$nombre]) . '</td>';
            $resultado.= '</tr>';
            $resultado.= '</tbody>';
            $resultado .= '</table>';
            $resultado .= '</div>';
        } else {
            $mensaje = $nombre . ' no está en la lista.';
        }

}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
    />
    <title>Buscar Estudiante</title>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Buscar Estudiante</h3>

                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Introduce el nombre del estudiante</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Carmen" required
                                   value="<?php echo htmlspecialchars($nombre); ?>">
                        </div>
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Buscar estudiante
                            </button>
                        </div>
                    </form>

                    <?php
                    if ($resultado !== "") {
                        echo $resultado;
                    }

                    if ($mensaje !== "") {
                        echo '<div class="alert alert-warning text-center">' . $mensaje . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mb-3"><a href="index.php">Volver al inicio</a></div>

</body>
</html>
