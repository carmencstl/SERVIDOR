<?php

    require_once "clases/Usuario.php";
    final class Sesion {
        private static $instance = null;
        private ?Usuario $usuario;

        private function __construct() {
            session_start();
            if (isset($_SESSION["usuarioActivo"])) {
                $this->usuario = $_SESSION["usuarioActivo"];
            }
        }

        /**
         * @return void
         *
         */
        private function __clone() {}


        /**
         * @return Sesion
         *
         */
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new Sesion();
            }
            return self::$instance;
        }

        /**
         * @param Usuario $usuario
         * @return void
         *
         */
        public function iniciarSesion(Usuario $usuario) {
            $this->usuario = $usuario;
            $_SESSION["usuarioActivo"] = $usuario;
        }

        /**
         * @return void
         */
        public function cerrarSesion() {
            $this->usuario = null;
            session_destroy();
        }

        /**
         * @return bool
         */
        public function estaLogueado() {
            return $this->usuario !== null;
        }

        /**
         * @return Usuario|null
         */
        public function getUsuario() {
            return $this->usuario;
        }
    }