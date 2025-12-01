<?php

    namespace Clases;

    //sera unicamente instanciada
    final class BaseDatos
    {

        private const DBHOST="db";
        private const USER="root";
        private const PASS="root";
        private const DBNAM="pruebas";

        private static ?BaseDatos $db=null;
        private ?\PDO\Mysql $pdo; //esta es la conexion a la base de datos barra inicial para cosas de php
        private \PDOStatement $stmt;

        private function __construct()
        {
            try{
                $dsn = "mysql:host=db;dbname=pruebas;charset=utf8";
                $this->pdo = PDO::connect($dsn, "root", "root");
            }catch (\PDOException $pdoe){
                die("ERROR");
            }
        }
        private function __clone(): void
        {
        }

        public static function conectar():BaseDatos
        {
            if(self::$db===null) self::$db=new BaseDatos();
            return self::$db;
        }

        public function consulta(string $sql, array $params):void
        {
            $stmt=$this->pdo->prepare($sql);


        }

        public function todos():array
        {
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);

        }

        public function cerrar():void
        {
            $this->pdo=null;
        }
    }