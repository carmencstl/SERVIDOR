<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Array de numeros</title>
</head>
<body>
</body>
</html>
<div class="container">
<?php

$valores = [
    "1"  => 11,
    "2"  => 0,
    "3"  => 10,
    "4"  => 0,
    "5"  => 0,
    "6"  => 0,
    "7"  => 0,
    "10" => 2,
    "11" => 3,
    "12" => 4
];

$palos = ["oros", "copas", "espadas", "bastos"];

$mazo = [];
foreach ($valores as $valor => $puntos) {
    foreach ($palos as $palo) {
        $mazo[] = ["valor" => $valor, "puntos" => $puntos, "palo" => $palo];
    }
}

shuffle($mazo);
$mano = array_slice($mazo, 0, 11);

$suma = 0;
echo " Mano de 10 cartas <br>";
foreach ($mano as $carta) {
    echo "Carta: {$carta['valor']} de {$carta['palo']} - Puntos: {$carta['puntos']}<br>";
    $suma += $carta["puntos"];
}

echo "<br>Suma total de puntos: $suma <br>";

echo $suma >= 60 ? "Has ganado!!" :  "No has ganado!!";
?>
</div>


