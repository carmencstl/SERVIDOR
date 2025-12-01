<?php
/**Crea la conexion a la base de datos y la devuelve.
 * @return void
 */
function createConnection(): object
{
    try {
        $dsn = "mysql:host=db;dbname=pruebas;charset=utf8";
        $pdo = PDO::connect($dsn, "root", "root");

    }catch (PDOException $pdoe){
        die("***ERROR: ".$pdoe->getMessage());
    }
    return $pdo;
}
