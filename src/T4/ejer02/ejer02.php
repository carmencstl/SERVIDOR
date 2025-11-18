<!--Crea una función que reciba dos parámetros: nombre y apellido, -->
<!--donde este último debe ser opcional. La función mostrará el apellido y, -->
<!--separado por coma, el nombre. -->
<!--Si no se pasa apellido alguno se mostrará sólo el nombre. -->
<!--Recuerda que la función no tendrá ningún tipo de retorno.-->

<?php

function mostrarNombre(string $nombre, string $apellido = ""): void
{
    echo $apellido === "" ? $nombre : $apellido . ", " . $nombre;
}

mostrarNombre("Carmen", "Castillo");