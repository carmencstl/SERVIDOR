<?php
include "../ejer06/ejer06.php";

function generaArray(int $totalElementos, int $min, int $max): array
{
    $array = [];
    for($i = 0; $i < $totalElementos; $i++){
        $array[$i] = rand($min, $max);
    }
    return $array;
}

$numeros = (generaArray(4, 0, 21));
print_r($numeros);
echo "<br>";
function minimoArray(array $array): int | float
{
    $minimo = PHP_INT_MAX;
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] < $minimo) {
            $minimo = $array[$i];
        }
    }
    return $minimo;
}
function maximoArray(array $array): int | float
{
    $maximo = -1;
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] > $maximo) {
            $maximo = $array[$i];
        }
    }
    return $maximo;
}

function mediaArray(array $array): int | float
{
    $suma = array_sum($array);
    return $suma / count($array);
}

function estaEnArray(int $i, array $array): bool
{

   return in_array($i, $array);
}


function posicionEnArray(int $i, array $array): false | int
{
    return array_search($i, $array);
}

function rotarDerecha($array, $n) {
    $longitud = count($array);
    return array_merge(
        array_slice($array, -$n),
        array_slice($array, 0, $longitud - $n)
    );
}

function rotarIzquierda($array, $n) {
    return array_merge(
        array_slice($array, $n),
        array_slice($array, 0, $n)
    );
}
