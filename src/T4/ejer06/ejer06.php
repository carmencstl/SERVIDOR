<?php

function esCapicua(int $n): bool
{
     return voltea($n) == (string)$n;
};

function esPrimo(int $n): bool
{
    $esPrimo = false;
    $cont = 0;
    for ($i = 1; $i <= $n; $i++){
        if($n % $i == 0){
            $cont++;
        }
    }
    if($cont == 2){
        $esPrimo = true;
    }
    return $esPrimo;
}

function siguientePrimo(int $n): int
{
      do{
          $n++;
      }while(!esPrimo($n));
      return $n;
}

function pontencia(int | float $base, int $exp): int | float
{
    return $base**$exp;
}

function digitos(int $n): int
{
    return strlen((string)$n);
}

function voltea(int $n): int
{
    return strrev((string)($n));
}
function digitoN(int $num, int $pos): int
{
    return ((string)$num)[$pos];
}

function quitaDerecha(int $num, int $digitos): int
{
    $digitos *= -1;
    return substr((string)$num, 0,  $digitos);
}

function quitaIzquierda(int $num, int $digitos): int
{
    return substr((string)$num,  $digitos);
}

function  pegaDerecha(int $num, int $digito): int
{
        return (string)$num . (string)$digito;
}
function  pegaIzquierda(int $num, int $digito): int
{
    return (string)$digito . (string)$num;
}



