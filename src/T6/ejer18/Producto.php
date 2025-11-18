<?php

abstract class Producto {

    protected $nombre;
    protected $precio;
    private static $totalProductos = 0;

    public function __construct()
    {
        self::$totalProductos++;
    }

    /**
     * @return mixed
     */
    public abstract function mostrarDetalles();

    /**
     * @param int $porcentaje
     * @return void
     */
    public function aplicarDescuento(int $porcentaje): void
    {
        $descuento = ($this->precio * $porcentaje) / 100;
        $this->precio -= $descuento;
    }

    /**
     * @return int
     */
    public static final function obtenerTotalProductos(): int
    {
        return self::$totalProductos;
    }
}