<?php
require_once 'Persona.php';

$nombre = $_POST['nombre'] ?? '';
$edad = $_POST['edad'] ?? '';
$email = $_POST['email'] ?? '';

$persona = new Persona($nombre, $edad, $email);

$serializado = serialize($persona);
$personaDeserializada = unserialize($serializado);

echo "<h2>Objeto Deserializado:</h2>";
echo $personaDeserializada;

?>
