<?php
try{

    $dsn = "mysql:host=db;dbname=servidorDAW;charset=utf8";
    $pdo = PDO::connect($dsn, "root", "root" ); #De clase PDO\MySQL
} catch (PDOException $pdoe) {
    die("ERROR {$pdoe->getMessage()}");
}