<?php

class Administrador extends Usuario implements Autenticable{

    use AccionesComunes;

    /**
     * @return void
     */
    public function acceder(): void
    {
        echo "El administrador {$this->nombre} ha entrado al sistema <br>";
    }

    /**
     * @return void
     */
    public function autenticar(): void
    {
        echo "Autenticando el administrador {$this->nombre} <br>";
    }

}