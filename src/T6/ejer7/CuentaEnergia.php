<?php

class CuentaEnergia{


    public private(set) int $id;
    public private(set) float $saldo;
    private readonly string $titular;
    public private(set) bool $activa;


    /**
     * @param int $id
     * @param string $titular
     */
    public function __construct(int $id, string $titular)
    {
        $this->id = $id;
        $this->saldo = 0;
        $this->titular = $titular;
        $this->activa = true;
    }

    public function generar($cantidad): void
    {
        if($this->activa)
        {
            $this->saldo += $cantidad;
        }
    }

    public function consumir($cantidad): false
    {
        if($this->saldo >= $cantidad){
            $this->saldo -= $cantidad;
        }
        return false;
    }

    public final function resumen(): string
    {
        return "{$this->titular}<br>
                {$this->saldo}<br>                   
                {$this->activa} <br>";
    }

    public function __toString(): string
    {
       return $this->resumen();
    }

    public function setSaldo(float $saldo): void
    {
        $this->saldo = $saldo;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }




}