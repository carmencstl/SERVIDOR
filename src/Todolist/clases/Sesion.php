<?php


    namespace Clases;

    //hacerlo singleton
    //controla todo lo relacionado con la sesion
    final class Sesion
    {
        private static ?Sesion $instancia=null;

        public static function startSesion(): void
        {

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