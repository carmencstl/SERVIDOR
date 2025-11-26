<?php


    final class BaseDatos
    {
        private const DBHOST = "db";
        private const DBUSER = "root";
        private const DBPASS = "root";
        private const DBNAME = "crudGabit";
        private static ?BaseDatos $instance = null;
        private ?PDO\Mysql $pdo;

        private PDOStatement $stmt;

        /**
         * @return void
         */
        private function __clone(){}
        private function __construct(){
            try{
                $dsn = "mysql:host=".self::DBHOST.";dbname=".self::DBNAME.";charset=utf8";
                $this->pdo = PDO\Mysql::connect($dsn, self::DBUSER, self::DBPASS ); #De clase PDO\MySQL

            } catch (PDOException $pdoe) {
                die("ERROR {$pdoe->getMessage()}");
            }
            return $this->pdo;
        }

        /**
         * @return BaseDatos
         */
        public static function conectar(): BaseDatos
        {
            if(is_null(self::$instance)) self::$instance = new BaseDatos();
            return self::$instance;
        }

        /**
         * @param string $sql
         * @param array $params
         * @return void
         */
        public function consultar(string $sql, array $params = []): void
        {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($params);
        }

        /**
         * @return void
         */
        public function todos(): void
        {
            $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function fila(string $clase): void
        {
            $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * @return void
         */
        public  function desconectar(): void
        {
            $this->pdo = null;
        }

    }