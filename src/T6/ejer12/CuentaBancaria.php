<?php

class CuentaBancaria extends Cuenta
{
    use Autenticable;

    /**
     * @param int|float $cantidad
     * @return void
     */
    public function retirar(int | float $cantidad): void
    {
        $this->autenticar();
        if($this->saldo >= $cantidad){
            $this->saldo -= $cantidad;
        }
    }
}

