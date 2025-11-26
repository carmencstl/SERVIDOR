<?php

    require_once "../clases/Request.php";
    class Sesion
    {
        #HACERLO SINGLETON
//        public static function login($usuario)




        /**
         * @return never
         */
        public static function cerrarSesion(): never
        {
            session_start();
            $_SESSION = [];
            session_destroy();
            Request::redirect("login.php");
        }
    }