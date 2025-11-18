<?php

class Empleado
{
    protected string $nombre;

    /**
     * @return void
     */
    public function trabajar(): void
    {
        echo "El empleado está trabajando <br>";
    }
}
