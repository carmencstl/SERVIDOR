<?php

function generaArray($x, $y, $max, $min): array
{
    $array = [];
    for($i = 0; $i < $x; $i++){
        for($j = 0; $j < $y; $j++){
            $array[$i][$j] = rand($min, $max);
        }
        "<br>";
    }
    return $array;
}


function filaArray(array $array, int $fila): ?array
{
    $filas = null;
    if(isset($array[$fila])){
        $filas = $array[$fila];

    }
    return $filas;
}

$matriz = generaArray(4, 7, 13, 141);

echo "<pre>";
echo print_r($matriz);
echo "</pre>";

function columnaArray(array $array, int $columna): array
{
    $columnaArray = [];

    foreach ($array as $fila) {
        if (isset($fila[$columna])) {
            $columnaArray[] = $fila[$columna];
        }
    }

    return $columnaArray;
}


function buscarCoordenadas(array $matriz, $numero): ?array
{
    $coordenadas = [];
    foreach ($matriz as $i => $fila) {
        foreach ($fila as $j => $valor) {
            if ($valor === $numero) {
                $coordenadas = ["fila" => $i, "columna" => $j];
            }
        }
    }
    return $coordenadas;
}

function puntoDeSilla(array $matriz, $numero): bool
{
    $esPuntoSilla = false;

    foreach ($matriz as $i => $fila) {
        foreach ($fila as $j => $valor) {
            if ($valor === $numero) {
                $minFila = min($fila);
                $columna = [];
                foreach ($matriz as $filaTemp) {
                    if (isset($filaTemp[$j])) {
                        $columna[] = $filaTemp[$j];
                    }
                }
                $minColumna = min($columna);

                if ($numero === $minFila && $numero === $minColumna) {
                    $esPuntoSilla = true;
                }
            }
        }
    }

    return $esPuntoSilla;
}

