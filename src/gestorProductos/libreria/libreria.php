<?php

/**
 *Comprueba que no haya precios negativos
 * @param $precio
 * @return bool
 */
function comprobarPrecio($precio): bool
{
    return $precio > 0;
}

/**
 * @param $filtro
 * @param $array
 * @return array
 *
 */
function ordenar($filtro, $array): array
{
    $resultado = $array;

    switch ($filtro) {
        case "a-z":
            usort($resultado, function($a, $b) {
                return strcmp($a["nombre"], $b["nombre"]);
            });
            break;

        case "z-a":
            usort($resultado, function($a, $b) {
                return strcmp($b["nombre"], $a["nombre"]);
            });
            break;

        case "Menor a mayor precio":
            usort($resultado, function($a, $b) {
                return $a["precio"] <=> $b["precio"];
            });
            break;

        case "Aceites":
            $resultado = array_filter($resultado, function($producto) {
                return $producto["categoria"] == "Aceites";
            });
            $resultado = array_values($resultado);
            break;

        default:
            break;
    }

    return $resultado;
}


function mayorCategoria(array $array) : string
{
    $conteos = [];
    foreach ($array["productos"] as $producto) {
        $categoria = $producto["categoria"];
        if (!isset($conteos[$categoria])) {
            $conteos[$categoria] = 0;
        }
        $conteos[$categoria]++;
    }

    return array_search(max($conteos), $conteos, true);

}