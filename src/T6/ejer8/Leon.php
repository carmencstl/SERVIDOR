<?php

class Leon extends Animal{

    public int $manada;

    /**
     * @return bool
     */
    public function cazar(): bool
    {
        $exito = rand(0,1);
        $nuevoPeso = $this->peso;
        if($exito){
            $pesoPerdido = $this->peso * 0.02;
        }
        else{
            $pesoPerdido = $this->peso * 0.05;
        }
        $nuevoPeso -= $pesoPerdido;
        $this->setPeso($nuevoPeso);
        echo $mensaje = $exito ? "Caza exitosa" : "Caza fallida" . "<br>";
        echo "Peso perdido: {$pesoPerdido} <br>";
        echo "Nuevo peso: {$nuevoPeso} <br>";
        return $exito;
    }

    public function alimentar(float $kgs): void
    {
        if($this->cazar()){
            parent::alimentar($kgs += $kgs * 0.2);
        }

    }


}