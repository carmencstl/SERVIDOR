<!--Define una función que reciba un número variable de números y devuelva su suma.-->

<?php

function sumaVariable(...$n): int | float
{
    return array_sum($n);
}

echo sumaVariable(3, 4);