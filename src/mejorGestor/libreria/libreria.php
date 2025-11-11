<?php

/**
 * Comprueba que las notas vayan del 1 al 10
 * @param array $notas
 * @return bool
 */
function comprobarNotas(array $notas) : bool
{
    $i = 0;
    while ($i < count($notas) && $notas[$i] >= 0 && $notas[$i] <= 10) {
        $i++;
    }
    return $i == count($notas);
}

/**
 * Calcula la media
 * @param array $notas
 * @return int|float
 */
function calcularMedia(array $notas) : int | float
{
    return array_sum($notas) / count($notas);
}

