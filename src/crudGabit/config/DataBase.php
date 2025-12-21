<?php
namespace CrudGabit\Config;

use PDO;
use PDOException;

final class DataBase {
    private const DBHOST = "dwes-db";
    private const DBUSER = "root";
    private const DBPASS = "root";
    private const DBNAME = "crudGabit";

    private static ?DataBase $instance = null;
    private ?PDO $pdo = null;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . self::DBHOST . ";dbname=" . self::DBNAME . ";charset=utf8";
            // CORRECCIÓN: Usar la clase PDO estándar de PHP
            $this->pdo = new PDO($dsn, self::DBUSER, self::DBPASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERROR DE CONEXIÓN: " . $e->getMessage());
        }
    }

    public static function getInstance(): DataBase {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    public static function connect(): PDO {
        return self::getInstance()->getConnection();
    }
}