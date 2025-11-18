<?php
function miFiltro(array $datos, callable $function): array
{       $array = [];
        foreach($datos as $dato){

             $function($dato) ? array_push($array, $dato) : "" ;
        }
        return $array;
}

$numeros = [1,2,3,4,5,6,7,8,9,10];

$pares = miFiltro($numeros, function($item){
    return $item % 2 == 0;});

print_r($pares);

