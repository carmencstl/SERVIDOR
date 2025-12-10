<?php

    require_once "modelos/Usuario.php";
    final class DataBase
    {
        private const DBHOST = "db";
        private const DBUSER = "root";
        private const DBPASS = "root";
        private const DBNAME = "Blogify";

        private static ?DataBase $instance = null;
        private ?PDO $pdo;
        private ?PDOStatement $stmt = null;

        /**
         * @return void
         */
        private function __clone()
        {
        }

        private function __construct()
        {
            try {
                $dsn = "mysql:host=" . self::DBHOST . ";dbname=" . self::DBNAME . ";charset=utf8";
                $this->pdo = new PDO($dsn, self::DBUSER, self::DBPASS); #De clase PDO\MySQL
            } catch (PDOException $pdoe) {
                die("ERROR {$pdoe->getMessage()}");
            }
            return $this->pdo;
        }

        /**
         * @return DataBase
         */
        public static function conectar(): DataBase
        {
            if (is_null(self::$instance)) self::$instance = new DataBase();
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

        public function comprobar(string $sql, array $params = []): int
        {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($params);
            return $this->stmt->rowCount();
        }

        /**
         * @return array
         */
        public function obtenerResultados(): array
        {
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * @param string $correo
         * @param string $password
         * @return bool
         */
        public function autenticarUsuario(string $correo, string $password): bool
        {
            $sql = "SELECT password FROM usuario WHERE email = :correo";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindParam(":correo", $correo);
            $this->stmt->execute();

            if($this->stmt->rowCount() > 0){
                $usuario = $this->stmt->fetch(PDO::FETCH_ASSOC);
                return $password === $usuario["password"];
            }
            return false;
        }

        public function buscarUsuarioPorCorreo(string $correo): ?Usuario
        {
            $sql = "SELECT * FROM usuario WHERE email = :correo";
            $this->consultar($sql, [
                ":correo" => $correo
            ]);
            $usuario = $this->stmt->fetchObject(Usuario::class);
            return $usuario ?: null;
        }

    }