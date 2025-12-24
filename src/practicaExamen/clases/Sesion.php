<?php

    final class Sesion
    {

        private static ?\Practicas\src\Sesion $instance = null;
        private function __construct()
        {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        /**
         * @return \Practicas\src\Sesion
         */
//        public static function init(): \Practicas\src\Sesion
//        {
//            if (self::$instance === null) {
//                self::$instance =
//            }
//            return self::$instance;
//        }

        /**
         * @param string $clave
         * @param mixed $valor
         * @return void
         */
        public function set(string $clave, mixed $valor): void
        {
            $_SESSION[$clave] = $valor;
        }

        /**
         * @param string $clave
         * @return mixed
         */
        public function get(string $clave): mixed
        {
            return $_SESSION[$clave] ?? null;
        }

        /**
         * @return bool
         */
        public function active(): bool
        {
            return !empty($_SESSION);
        }


    }