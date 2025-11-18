<!--Crear una clase que represente una cuenta bancaria. -->
<!--La clase debe permitri consultar el saldo publicamente, pero solo modificalro desde dentro de la clase o clases hijas, -->
<!--no desde fuera.-->
<!--La clase debe definir las propiedades titular y saldo y los metodos:-->
<!---->
<!--1. depositar: deposita dinero en la cuenta-->
<!--2. retirar: si hay saldo, retira dinero de la cuenta y devuelve verdadero; en otro caso devuelve falso.-->
<!---->
<!--Definida la clase, atributos y metodos, crea un script que la utilice,-->
<!--depositando, retirando, mostrando info de titular y saldo.-->

<?php

Class CuentaBancaria{

    public function __construct(private string $titular, public private(set) float $saldo)
    { }

    /**
     * @param float $dinero
     * @return void
     */
    public function depositar(float $dinero): void
    {
        $this->saldo += $dinero;
    }

    /**
     * @param float $dinero
     * @return bool
     */
    public function retirar(float $dinero): bool
    {
        $resultado = false;
        if($this->saldo >= $dinero)
        {
            $this->saldo -= $dinero;
            $resultado = true;
        }
        return $resultado;
    }


}