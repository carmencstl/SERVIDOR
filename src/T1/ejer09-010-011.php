<?php
$colores = ["rojo", "verde", "azul"];
$colores = [...$colores, "amarillo"];
print_r($colores);
echo "<br>";
$colores[1] = "morado";
print_r($colores);