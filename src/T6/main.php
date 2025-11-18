<?php
/* require_once "Libro.php"; */
require_once "Pelicula.php";

/* $persona = new Persona("Juan", 30); */
/* $libro = new Libro("Almendra", "Pablo Beentjes", "28-10-2025", 50);

echo "Titulo: " . $libro->titulo . " Autor: " . $libro->autor . " Fecha: " . $libro->publicacion . " Stock: " . $libro->stock;
$libro->vender();
$libro->vender();
$libro->vender();
$libro->vender();
$libro->vender();
$libro->reponer(3); 
echo "<br>";
echo "Titulo: " . $libro->titulo . " Autor: " . $libro->autor . " Fecha: " . $libro->publicacion . " Stock: " . $libro->stock;

$libro->publicacion = "hoy"; */


$pelicula = new Pelicula(1, "Las aventuras de Pablo", "Pablo", "hoy");
echo $pelicula->infoCorta();
?>