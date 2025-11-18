<?php

class Producto{

    private string $nombre{
        get{
           return ucfirst($this->nombre);
        }
    }
    private float $precio;
    private string $categoria;


    /**
     * @param string $nombre
     * @param float $precio
     * @param string $categoria
     */
    public function __construct(string $nombre, float $precio, string $categoria)
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
       return "
               Nombre: {$this->nombre} . <br>
               Precio: {$this->precio} . <br>
               Categoria: {$this->categoria} . <br>
       ";
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return float
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * @return string
     */
    public function getCategoria(): string
    {
        return $this->categoria;
    }


}
