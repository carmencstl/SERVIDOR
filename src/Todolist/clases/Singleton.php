<?php

    namespace Clases;


    class Singleton
    {
        //la clase controla su instanciacion
        private static ?Singleton $instancia=null;

        private function __construct()
        {

        }

        public static function getIntance(): Singleton
        {
            if(self::$instancia==null) self::$instancia=new Singleton();
            return self::$instancia;
        }

        //tampoco debe poder clonarse
        private function __clone(): void
        {
            // TODO: Implement __clone() method.
        }
    }