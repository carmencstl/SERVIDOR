<?php

class Desarrollador extends Empleado
{

    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return void
     */
    public function trabajar(): void
    {
        echo "El desarrollador {$this->nombre} está programando <br>";
    }

}
