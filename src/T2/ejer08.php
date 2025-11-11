<?php

$puntuacion = 69;

echo match (true) {
    $puntuacion < 50 => "Novato",
    $puntuacion < 70 => "Intermedio",
    $puntuacion < 90 => "Avanzado",
    $puntuacion <= 100 => "Experto",
    default => "Puntuacion invalida"
};
