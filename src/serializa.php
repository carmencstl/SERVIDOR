<?php
require_once 'Persona.php';

$nombre = $_POST['nombre'] ?? '';
$edad = $_POST['edad'] ?? '';
$email = $_POST['email'] ?? '';

$persona = new Persona($nombre, $edad, $email);

$serializado = serialize($persona);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Objeto Serializado</title>
</head>
<body>
    <h2>Objeto serializado listo para enviar</h2>

    <form action="deserializa.php" method="post">
        <textarea name="objeto" rows="5" cols="80" readonly><?= htmlspecialchars($serializado) ?></textarea><br><br>
        <input type="hidden" name="objeto" value="<?= htmlspecialchars($serializado) ?>">
        <input type="submit" value="Deserializar en otro archivo">
    </form>
</body>
</html>