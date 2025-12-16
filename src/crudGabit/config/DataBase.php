<?php


namespace CrudGabit\Config;

use PDO;
use PDOException;
use PDOStatement;
use PDO\Mysql;

/**
 * Clase Database - Patrón Singleton para conexión a BD
 */
final class DataBase
{
    private const DBHOST = "db";
    private const DBUSER = "root";
    private const DBPASS = "root";

    private const DBNAME = "crudGabit";

    private static ?DataBase $instance = null;
    private ?Mysql $pdo;
    private ?PDOStatement $stmt = null;

    /**
     * Metodo clonar privado para evitar la clonacion del objeto
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Constructor privado para evitar la instanciacion directa
     * @return Mysql
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . self::DBHOST . ";dbname=" . self::DBNAME . ";charset=utf8";
            $this->pdo = Mysql::connect($dsn, self::DBUSER, self::DBPASS);

        } catch (PDOException $pdoe) {
            die("ERROR {$pdoe->getMessage()}");
        }
        return $this->pdo;
    }

    /**
     * @return DataBase
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * Metodo estatico para obtener la conexion a la base de datos
     * @return PDO
     */
    public static function conectar(): PDO
    {
        return self::getInstance()->getConnection();
    }
}