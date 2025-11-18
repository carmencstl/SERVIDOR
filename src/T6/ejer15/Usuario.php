<?php

abstract class Usuario
{
    protected string $nombre;

    private static int $totalUsuarios = 0;


    public function __construct()
    {
        self::$totalUsuarios++;
    }

    /**
     * @return mixed
     */
    public abstract function acceder();

    /**
     * @return int
     */
    public static final function obtenerTotalUsuarios(): int
    {
        return self::$totalUsuarios;
    }

}
