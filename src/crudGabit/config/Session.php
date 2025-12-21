<?php

namespace CrudGabit\Config;

/**
 * Clase Session - Gestión de sesiones
 */
class Session
{
    private const TIEMPO_EXPIRACION = 3600; // 1 hora en segundos

    /**
     * Iniciar sesión PHP
     */
    private static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configuramos la cookie para que sea válida en todo el localhost
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/', // Importante: '/' permite que se lea en todas las subcarpetas
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
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

        $userId = $usuario->getId();

        $_SESSION["id"] = $userId;
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

        return isset($_SESSION["id"]) && isset($_SESSION["ultima_actividad"]);
    }

    /**
     * Cerrar sesión
     * @return void
     */
    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Obtener valor de sesión
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Establecer valor en sesión
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Verificar si existe una clave
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Eliminar una clave
     * @param string $key
     * @return void
     */
    public static function delete(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Verificar y gestionar expiración de sesión
     * @return void
     */
    private static function verificarExpiracion(): void
    {
        if (isset($_SESSION["ultima_actividad"])) {
            $tiempoInactivo = time() - $_SESSION["ultima_actividad"];

            if ($tiempoInactivo > self::TIEMPO_EXPIRACION) {
                self::logout();
                return;
            }
        }

        $_SESSION["ultima_actividad"] = time();
    }

    /**
     * Obtener tiempo restante de sesión
     * @return int
     */
    public static function getTiempoRestante(): int
    {
        self::start();

        $resultado = 0;

        if (isset($_SESSION["ultima_actividad"])) {
            $tiempoTranscurrido = time() - $_SESSION["ultima_actividad"];
            $tiempoRestante = self::TIEMPO_EXPIRACION - $tiempoTranscurrido;
            $resultado = max(0, $tiempoRestante);
        }

        return $resultado;
    }

    /**
     * Renovar sesión
     * @return void
     */
    public static function renovarSesion(): void
    {
        self::start();
        $_SESSION["ultima_actividad"] = time();
    }
}