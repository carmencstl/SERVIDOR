<?php

namespace Practicas\src;

final class Request
{
    private function __construct()
    {
    }

    /**
     * Redirige a la URL especificada.
     * @param string $url
     * @return never
     */
    public static function redirect(string $url):never
    {
        header("Location: {$url}");
        exit();
    }
}