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

$filas = 6;
$columnas = 9;
$matriz = [];
$repetidos = [];


for ($i = 0; $i < $filas; $i++) {
    for ($j = 0; $j < $columnas; $j++) {
        do {
            $num = rand(100, 999);
        } while (in_array($num, $repetidos));
        $matriz[$i][$j] = $num;
        $repetidos[] = $num;
    }
}

$minimo = PHP_INT_MAX;
$minFila = -1;
$minCol = -1;

for ($i = 0; $i < $filas; $i++) {
    for ($j = 0; $j < $columnas; $j++) {
        if ($matriz[$i][$j] < $minimo) {
            $minimo = $matriz[$i][$j];
            $minFila = $i;
            $minCol = $j;
        }
    }
}


echo "<table class='table'>";
for ($i = 0; $i < $filas; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $columnas; $j++) {
        $color = "black";
        if ($i == $minFila && $j == $minCol) {
            $color = "blue";
        } elseif (($i - $j) == ($minFila - $minCol) || ($i + $j) == ($minFila + $minCol)) {
            $color = "green"; // diagonales donde está el mínimo
        }

        echo "<td style='color:$color'>" . $matriz[$i][$j] . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
