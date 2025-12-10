<?php

    class Sesion
    {
        private static $instance = null;

        private function __construct()
        {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public static function getInstance(): \Practicas\src\Sesion
        {
            if (self::$instance === null) {
                self::$instance = new \Practicas\src\Sesion();
            }
            return self::$instance;
        }

        public function obtenerUsuario(): ?Usuario
        {
            return $_SESSION["usuarioActual"] ?? null;
        }

        public function iniciarSesion(Usuario $usuario): void
        {
            $_SESSION["usuarioActual"] = $usuario;
        }

        public function cerrarSesion(): void
        {
            $_SESSION = [];
            session_destroy();
        }

        public function esAdmin(): bool
        {
            $usuarioActual = $this->obtenerUsuario();
            return $usuarioActual !== null && $usuarioActual->getRol() === "admin";
        }

        private function __clone() {}
    }