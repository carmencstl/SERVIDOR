<?php

class Libro{

    public function __construct(
                                 public private(set) string $titulo, 
                                 public private(set) string $autor,
                                 public readonly int $publicacion,
                                 public private(set) int $stock
    ) {}

    /**
     * @param 
     * @return void
    */
    public function vender(): void
    {
        if($this->stock > 0){
            $this->stock--;
        }
    }

    /**
     * @param int $cantidad
     * @return void
     */
    public function reponer(int $cantidad): void
    {
        $this->stock += $cantidad;
    }



}