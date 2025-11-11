<?php
require_once 'Persona.php';

$serializado = $_POST['objeto'] ?? '';

if ($serializado) {
    $persona = unserialize($serializado);
} else {
    die("No se recibió ningún objeto.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Objeto Deserializado</title>
</head>
<body>
    <h2>Objeto Deserializado Correctamente</h2>
    <?= $persona->mostrarInfo() ?>
</body>
</html>