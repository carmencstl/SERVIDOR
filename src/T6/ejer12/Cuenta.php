<?php

class Cuenta{

    protected float $saldo;

    /**
     * @param $cantidad
     * @return void
     */
    public function depositar(int | float $cantidad): void
    {
        $this->saldo += $cantidad;
    }

    /**
     * @return void
     */
    public function mostrarSaldo(): void
    {
        echo $this->saldo;
    }
}
