<?php

namespace Practicas\src;

use Usuario;

class Sesion
{
    private static ?Sesion $instance = null;

    private function __clone()
    {
    }


    /**
     * Constructor privado para implementar el patrón Singleton.
     * Comprueba si hay sesión iniciada y, si no la hay, la inicia.
     * @return void
     */
    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Obtiene la instancia única de la clase Sesion.
     * @return Sesion
     */
    public static function getInstance(): Sesion
    {
        if (self::$instance === null) {
            self::$instance = new Sesion();
        }
        return self::$instance;
    }

    /**
     * Obtiene el usuario actualmente autenticado en la sesión.
     * @return Usuario|null
     */
    public function obtenerUsuario(): ?Usuario
    {
        return $_SESSION["usuarioActual"] ?? null;
    }

    /**
     * Guarda el usuario en la sesión para iniciar sesión.
     * @param Usuario $usuario
     * @return void
     */
    public function iniciarSesion(Usuario $usuario): void
    {
        $_SESSION["usuarioActual"] = $usuario;
    }

    /**
     * Cierra la sesión actual y redirige a la página de inicio.
     * @return void
     */
    public static function cerrarSesion(): never
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        Request::redirect("index.php");
    }

}