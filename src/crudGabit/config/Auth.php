<?php

    namespace Clases ;

    use config\Session;
    use Modelos\Usuario;

    final class Auth
    {
        /**
         * @param string $email
         * @param string $pass
         * @return boolean
         */
        public static function login(string $email, string $pass): bool
        {
            $usuario = Usuario::getByEmailAndPassword($email, $pass) ;

            # iniciamos sesión si se ha encontrado el usuario
            if (is_object($usuario)) Sesion::init($usuario) ;

            #
            return is_object($usuario) ;
        }

        /**
         * @return Usuario|false
         */
        public static function user(): Usuario|false
        {
            # si hay una sesión activa recuperamos el usuario
            if (Sesion::active()):
                return Usuario::getById(Sesion::get("id")) ;
            endif ;

            return false ;
        }

        /**
         * Verificar rol del usuario actual
         * @return bool
         */
        public static function checkRol(): bool
        {
            $usuario = self::user();
            $resultado = false;

            if ($usuario) {
                $resultado = Usuario::comprobarRol($usuario->getId());
            }

            return $resultado;
        }

        /**
         * @return void
         */
        public static function logout(): void
        {

            Sesion::logout() ;
        }


    }