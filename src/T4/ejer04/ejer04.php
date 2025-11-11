<!--Define una función que acepte como parámetro un número o una cadena. -->
<!--Si el parámetro es un número devolverá el doble de su valor; -->
<!--si es una cadena, la función retornará su longitud.-->


<?php

function numeroCadena(string | int $a): int
{
    return gettype($a) == "string" ? strlen($a) : $a*2;
}


echo numeroCadena(2);