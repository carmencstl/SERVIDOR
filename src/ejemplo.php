<?php

#1 forma
$letras = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J");
echo($letras[3]), "<br>";

# 2 forma ESTA
$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9];
print_r($numeros);
echo "<br>";

#3 forma peligrosa EN ESTA FORMA SI USAMOS UNSET PARA DESTRUIR UNA VARIABLE Y DESPUES AÑADIMOS OTRO ELEMENTO
#ESTE NO SE AÑADE A LA POSICION QUE HEMOS DESTRUIDO, SINO A LA SIGUIENTE

$valores[] = 32;
$valores[] = 21;
$valores[] = 34;
$valores[] = 36;
var_dump($valores);

//Puedo indicar el indice de los arrays escalares también.

echo "<br>";
#Array asociativo
$meses = ["enero" => 1, "febrero" => 2, "marzo" => 3]; #"enero" seria el indice y 1 el valor.
print_r($meses);

echo "<br>";


//Array multidimensionales

$datos = [
    ["NEU", "Neumatico", 100], ["ACE", "Aceite", 80], ["BUJ", "Bujias", 4]
];

echo "<pre>" .print_r($datos, true) . "</pre>";

echo $datos[1][2];


//Operador de fusion nula

echo "<br>";
$resultado = null??$datos[1][1]??null??"Hola mundo";
echo $resultado;
echo "<br>";
//Operador Spaceship
echo 8<=>5;


//Ejercicio 15 EN EL WORD, HACER A PAPEL.

