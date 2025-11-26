<?php

/**
 * @return object|PDO
 *
 */
function conectarBD(): object
{
    try{

        $dsn = "mysql:host=db;dbname=crudGabit;charset=utf8";
        $pdo = PDO::connect($dsn, "root", "root" ); #De clase PDO\MySQL
        return $pdo;
    } catch (PDOException $pdoe) {
        die("ERROR {$pdoe->getMessage()}");
    }
}
