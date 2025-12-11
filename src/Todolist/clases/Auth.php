<?php

    namespace Clases;

    final class Auth
    {
        private ?Usuario $usuario = null;
        public function login (string $correo, string $password): ?Usuario
        {
            $usuario = null;

            if (($correo != null) and ($password != null)) {

                $db = BaseDatos::conectar();

                $sql = "SELECT * FROM usuario WHERE email = :correo AND password = :password";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
                $stmt->bindParam(":password", $password, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetchObject(Usuario::class);

                if (is_object($usuario)) {
                    $_SESSION["usuarioActual"] = $usuario;
                }
            }
            return $usuario;
        }



        public static function conectar(): void
        {
            if(Sesion::activa()){

                $sql = "SELECT * FROM usuario WHERE email = :correo AND password = :password";
            }
        }
    }