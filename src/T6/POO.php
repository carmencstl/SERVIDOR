<?php
require_once "CuentaBancaria.php";

$cuenta = new CuentaBancaria("Carmen", 1500);

echo "Muestro saldo actual: " . ($cuenta->saldo) . "<br>";
echo "Retiro 100:" . ($cuenta->retirar(100)) . "<br>";;
echo "Muestro después de retirar: ". ($cuenta->saldo) . "<br>";;
$cuenta->depositar(200);
echo  "Deposito 200: " . ($cuenta->saldo) . "<br>";;