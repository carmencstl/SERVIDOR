<?php
require_once 'Persona.php';


$serializado = $_POST["serie"];
$serializado = urldecode($serializado);
$personaDeserializada = unserialize($serializado);

echo "<h2>Objeto Deserializado:</h2>";
echo $personaDeserializada;

?>
