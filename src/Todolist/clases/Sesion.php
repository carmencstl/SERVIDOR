<?php


    namespace Clases;

    //hacerlo singleton
    //controla todo lo relacionado con la sesion
    use Practicas\src\Request;

    final class Sesion
    {
        private static ?Sesion $instancia=null;

        public static function activa(): bool
        {
            return session_status() === PHP_SESSION_ACTIVE;
        }
        public static function login(): Sesion
        {
            if(self::$instancia==null) self::$instancia=new Sesion();
            return self::$instancia;
        }
        public static function cerrarSesion():never
        {
            session_start();
            $_SESSION=[];
            session_destroy();
            Request::redirect("index.php"); //la direccion deberia ir en un archivo de conf
        }
    }