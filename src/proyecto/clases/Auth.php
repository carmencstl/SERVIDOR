<?php

    require_once "BaseDatos.php";
    require_once "Usuario.php";

    class Auth
    {
        private static ?Auth $instance = null;
        private BaseDatos $db;

        private function __construct()
        {
            $this->db = BaseDatos::conectar();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        private function __clone() {}

        public static function getInstance(): Auth
        {
            if (self::$instance === null) {
                self::$instance = new Auth();
            }
            return self::$instance;
        }

        public function autenticarUsuario(string $email, string $password): bool
        {
            $autenticado = false;
            $usuario = $this->db->buscarUsuarioPorCorreo($email);
            if ($usuario !== null && $usuario->getPassword() === $password) {
                $_SESSION["usuarioActual"] = $usuario;
                $autenticado = true;
            }

            return $autenticado;
        }

        public function logout(): void
        {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        }

        public function estaAutenticado(): bool
        {
            return isset($_SESSION["autenticado"]) && $_SESSION["autenticado"] === true;
        }

        public function protegerPagina(): void
        {
            if (!$this->estaAutenticado()) {
                header("Location: ../login.php");
                exit();
            }
        }

        public function verificarUsuarioExistente(string $email): bool
        {
            $usuario = $this->db->buscarUsuarioPorCorreo($email);
            return $usuario !== null;
        }

    }