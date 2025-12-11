<?php


//REVISAR NOMBRE DE LA CLASE

final class DataBase
{
    private const DBHOST = "db";
    private const DBUSER = "root";
    private const DBPASS = "root";

//    CAMBIAR ESTO
    private const DBNAME = "practica";

//    REVISAR NOMBRE DE LA CLASE
    private static ?DataBase $instance = null;
    private ?PDO\Mysql $pdo;
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
     * @return \Pdo\Mysql
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . self::DBHOST . ";dbname=" . self::DBNAME . ";charset=utf8";
            $this->pdo = PDO\Mysql::connect($dsn, self::DBUSER, self::DBPASS); #De clase PDO\MySQL

        } catch (PDOException $pdoe) {
            die("ERROR {$pdoe->getMessage()}");
        }
        return $this->pdo;
    }

        /**
         * Metodo que instancia la clase (Singleton)
         * @return \PDO\Mysql
         */                             //Revisar nombre de la clase
    public static function conectar(): PDO\Mysql
    {
        if (is_null(self::$instance)) self::$instance = new DataBase();
        return self::$instance->pdo;
    }
}