<?php

    require_once __DIR__ . "/Usuario.php";
    final class BaseDatos
    {
        private const DBHOST = "db";
        private const DBUSER = "root";
        private const DBPASS = "root";
        private const DBNAME = "crudGabit";
        private static ?BaseDatos $instance = null;
        private ?PDO\Mysql $pdo;
        private ?PDOStatement $stmt = null;

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
         * @return array
         */
        public function todo(): array
        {
            return $this->stmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        }

        /**
         * @param string $clase
         * @return void
         */
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

        /**
         * @param string $columna
         * @param $valor
         * @return void
         */

        public function filtrar(string $columna, $valor): void
        {
            $sql = "SELECT * FROM usuario WHERE $columna = :valor";
            $this->consultar($sql, [":valor" => $valor]);
        }

        /**
         * @param string $terminoBusqueda
         * @return void
         */
        public function buscar(string $terminoBusqueda): void
        {
            $sql = "SELECT * FROM usuario 
            WHERE email LIKE :correo 
            OR nombreUsuario LIKE :nombreUsuario";

            $patron = "%{$terminoBusqueda}%";

             $this->consultar($sql, [
                 ":correo" => $patron,
                 ":nombreUsuario" => $patron
             ]);
        }

        /**
         * @param string $correoOriginal
         * @param string $nombreUsuarioActualizar
         * @param string $nombreActualizar
         * @param string $apellidosActualizar
         * @param string $correoActualizar
         * @param string $rolActualizar
         * @return void
         */
        public function actualizarUsuario(string $correoOriginal, string $nombreUsuarioActualizar, string $nombreActualizar, string $apellidosActualizar, string $correoActualizar, string $rolActualizar): void
        {
            $sql = "UPDATE usuario SET nombreUsuario = :nombreUsuario, 
                                nombre = :nombre,
                                apellidos = :apellidos, 
                                email = :correo, 
                                rol = :rol 
            WHERE email = :correoOriginal";

            $this->consultar($sql, [
                ":nombreUsuario" => $nombreUsuarioActualizar,
                ":nombre" => $nombreActualizar,
                ":apellidos" => $apellidosActualizar,
                ":correo" => $correoActualizar,
                ":rol" => $rolActualizar,
                ":correoOriginal" => $correoOriginal
            ]);
        }

        /**
         * @param string $correo
         * @return void
         */
        public function borrarUsuario(string $correo): void
        {
            $sql = "DELETE FROM usuario WHERE email = :correo";
            $this->consultar($sql, [
                ":correo" => $correo
            ]);
        }

        /**
         * @return array
         */
        public function todoUsuarios(): array
        {
            $sql = "SELECT * FROM usuario";
            $this->consultar($sql);
            return $this->todo();
        }

        /**
         * @param string $correo
         * @return Usuario|null
         */
        public function buscarUsuarioPorCorreo (string $correo): ?Usuario
        {
            $sql = "SELECT * FROM usuario WHERE email = :correo";
            $this->consultar($sql, [
                ":correo" => $correo
            ]);
            $usuario = $this->stmt->fetchObject(Usuario::class);
            return $usuario ?: null;
        }

        /**
         * @param Usuario $usuario
         * @return void
         */
        public function insertarUsuario(Usuario $usuario): void
        {
            $sql = "INSERT INTO usuario (nombreUsuario, nombre, apellidos, email, password, rol, fechaRegistro) 
            VALUES (:nombreUsuario, :nombre, :apellidos, :email, :password, :rol, NOW())";

            $this->consultar($sql, [
                ":nombreUsuario" => $usuario->getNombreUsuario(),
                ":nombre" => $usuario->getNombre(),
                ":apellidos" => $usuario->getApellidos(),
                ":email" => $usuario->getEmail(),
                ":password" => $usuario->getPassword(),
                ":rol" => $usuario->getRol()
            ]);
        }

    }