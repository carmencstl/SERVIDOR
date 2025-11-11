<?php

class CuentaVerde extends CuentaBancaria{

    public int $paneles = 0;

    public function instalarPaneles($cantidad): void
    {
        $this->paneles += $cantidad;
        $nuevoSaldo = $this->saldo->getSaldo += ($cantidad * 2);
        $this->saldo->setSaldo($nuevoSaldo);
    }

    public function generar($cantidad): void
    {
        if($this->activa)
        {
            $nuevaCantidad = $cantidad + ($cantidad * 0.10);
            $this->saldo->setSaldo($nuevaCantidad);
        }
    }

}