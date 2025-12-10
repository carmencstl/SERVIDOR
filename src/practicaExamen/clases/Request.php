<?php

    class Request
    {
        private function __construct()
        {}


        /**
         * @param string $url
         * @return never
         */
        public static function redirect(string $url): never
        {
            header("Location: $url");
            exit();
        }

    }