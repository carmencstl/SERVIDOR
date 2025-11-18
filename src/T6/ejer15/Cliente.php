<?php

class Cliente extends Usuario implements Autenticable {

    use AccionesComunes;


    /**
     * @return void
     */
    public function autenticar(): void
    {
        echo "Autenticando al cliente {$this->nombre} <br>";
    }


    /**
     * @return void
     */
    public function acceder(): void
    {
        echo "El cliente {$this->nombre} ha accedido al cliente <br>";
    }


}