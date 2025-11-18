<?php

class Calculadora{

    public static final function sumar(int | float $a, int | float $b): int | float
    {
        return $a + $b;
    }

}

$calculadora = new Calculadora();

echo $calculadora->sumar(2, 2);