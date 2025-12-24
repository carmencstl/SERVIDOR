<?php

namespace CrudGabit\Config;

final class Request
{

    /**
     * Verificar si el método HTTP coincide con el dado
     * @param string $method
     * @return bool
     */
    public static function isMethod(string $method): bool
    {
        return strtolower($method) === strtolower($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * Obtener valor de POST o GET
     * @param string $key
     * @return string|null
     */
    public static function get(string $key): ?string
    {
        return $_POST[$key] ?? $_GET[$key] ?? null;
    }

    /**
     * Obtener todos los datos POST
     * @return array
     */
    public static function post(?string $key = null) : array|string|null
    {
        if ($key) {
            return $_POST[$key] ?? null;
        }

        return $_POST;
    }

    /**
     * Obtener todos los datos GET
     * @return array
     */
    public static function query(): array
    {
        return $_GET;
    }

    /**
     * Verificar si es POST
     * @return bool
     */
    public static function isPost(): bool
    {
        return self::isMethod("POST");
    }

    /**
     * Verificar si es GET
     * @return bool
     */
    public static function isGet(): bool
    {
        return self::isMethod("GET");
    }

    /**
     * Redirigir a URL con base /crudGabit
     * @param string $url
     * @return never
     */
    public static function redirect(string $path): void
    {
        if (strpos($path, "/crudGabit") === false) {
            $path = "/crudGabit" . (str_starts_with($path, "/") ? $path : "/" . $path);
        }
        header("Location: {$path}");
        exit;
    }


    /**
     * Obtener método HTTP actual
     * @return string
     */
    public static function method(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * Obtener URI actual
     * @return string
     */
    public static function uri(): string
    {
        return $_SERVER["REQUEST_URI"];
    }
}