<!--//Define una función que reciba dos números como parámetros y devuelva su suma.-->
<?php

function suma(int | float $a, int | float $b): int | float
{
    return $a + $b;
}

echo suma(3.4,4);