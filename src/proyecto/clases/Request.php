<?php

    final class Request
    {
        private function __construct()
        {}

        public static function redirect(string $url): never
        {
            header("Location: $url");
            exit();
        }
    }