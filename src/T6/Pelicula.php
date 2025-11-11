<?php

class Pelicula {


    /**
     * @param string $id
     * @param string $titulo
     * @param string $director
     * @param string $estreno
     * @param int $stock
     */
    public function __construct(
                                private readonly string $id,
                                public private(set) string $titulo,
                                public private(set) string $director,
                                public readonly string $estreno, 
                                public private(set) int $stock = 0
    ) {}

    /**
     * @param int $unidades
     * @return int|false
     */
    public function vender( int $unidades = 1): int | false
    {

         return ($this->stock >= $unidades) ? ($this->stock -= $unidades) : false;

    }

    /**
     * @param int $unidades
     * @return int
     */
    public function reponer( int $unidades = 1): int
    {
        return $this->stock += $unidades;
    }


    /**
     * @param string|null $nombre
     * @return void
     */
    public function renombrar(?string $nombre = null): void
    {
        if($nombre != null){
            $this->titulo = $nombre;
        }
    }

    /**
     * @return string
     */
    public function infoCorta(): string
    {
        $res  = "Título: " . $this->titulo . "<br>";
        $res .= " Director: " . $this->director . "<br>";
        $res .= " Estreno: " . $this->estreno . "<br>";    
        $res .= " Stock: " . $this->stock . "<br>";     
        
        return $res;
    }






}