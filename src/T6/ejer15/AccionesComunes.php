<?php

trait AccionesComunes{


    /**
     * @return void
     */
    public function cerrarSesion(): void
    {
        echo "Sesión cerrada para {$this->nombre}";
    }
}