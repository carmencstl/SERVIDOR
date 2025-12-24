<?php

namespace CrudGabit\Config;
class Session
{
    private const TIEMPO_EXPIRACION = 3600;

    /**
     * Iniciar sesión PHP
     */
    private static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        self::verificarExpiracion();
    }

    /**
     * Inicializar sesión de usuario (guarda ID)
     * @param object $usuario
     */
    public static function init($usuario): void
    {
        self::start();

        // Regenerar ID de sesión por seguridad
        session_regenerate_id(true);

        $_SESSION["id"] = $usuario->getId();
        $_SESSION["tiempo_inicio"] = time();
        $_SESSION["ultima_actividad"] = time();
    }

    /**
     * Verificar si hay sesión activa
     * @return bool
     */
    public static function active(): bool
    {
        self::start();

        return isset($_SESSION["id"]);
    }

    /**
     * Cerrar sesión
     */
    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    /**
     * Obtener valor de sesión
     */
    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Establecer valor en sesión
     */
    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Verificar si existe una clave
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Eliminar una clave
     */
    public static function delete(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Verificar y gestionar expiración de sesión
     */
    private static function verificarExpiracion(): void
    {
        if (!isset($_SESSION["ultima_actividad"])) {
            return;
        }

        $tiempoInactivo = time() - $_SESSION["ultima_actividad"];

        if ($tiempoInactivo > self::TIEMPO_EXPIRACION) {
            $_SESSION = [];
            session_destroy();
            return;
        }

        $_SESSION["ultima_actividad"] = time();
    }

    /**
     * Obtener tiempo restante de sesión
     */
    public static function getTiempoRestante(): int
    {
        self::start();

        if (!isset($_SESSION["ultima_actividad"])) {
            return 0;
        }

        $tiempoTranscurrido = time() - $_SESSION["ultima_actividad"];
        $tiempoRestante = self::TIEMPO_EXPIRACION - $tiempoTranscurrido;

        return max(0, $tiempoRestante);
    }

    /**
     * Renovar sesión manualmente
     */
    public static function renovarSesion(): void
    {
        self::start();
        $_SESSION["ultima_actividad"] = time();
    }
}
