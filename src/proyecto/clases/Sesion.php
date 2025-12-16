<?php

class Sesion
{
    private static $instance = null;
    private const TIEMPO_EXPIRACION = 3600; // 1 hora en segundos
    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->verificarExpiracion();
    }

    public static function getInstance(): Sesion
    {
        if (self::$instance === null) {
            self::$instance = new Sesion();
        }
        return self::$instance;
    }

    public function obtenerUsuario(): ?Usuario
    {
        return $_SESSION["usuarioActual"] ?? null;
    }

    public function iniciarSesion(Usuario $usuario, string $sesion): void
    {
        $_SESSION[$sesion] = $usuario;
        $_SESSION["tiempo_inicio"] = time();
        $_SESSION["ultima_actividad"] = time();
    }

    public function cerrarSesion(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public function esAdmin(): bool
    {
        $usuarioActual = $this->obtenerUsuario();
        return $usuarioActual !== null && $usuarioActual->getRol() === "admin";
    }

    private function verificarExpiracion(): void
    {
        if (isset($_SESSION["ultima_actividad"])) {
            $tiempoInactivo = time() - $_SESSION["ultima_actividad"];

            if ($tiempoInactivo > self::TIEMPO_EXPIRACION) {
                $this->cerrarSesion();
                return;
            }
        }

        // Actualizar tiempo de última actividad
        $_SESSION["ultima_actividad"] = time();
    }

    public function getTiempoRestante(): int
    {
        if (!isset($_SESSION["ultima_actividad"])) {
            return 0;
        }

        $tiempoTranscurrido = time() - $_SESSION["ultima_actividad"];
        $tiempoRestante = self::TIEMPO_EXPIRACION - $tiempoTranscurrido;

        return max(0, $tiempoRestante);
    }

    public function renovarSesion(): void
    {
        $_SESSION["ultima_actividad"] = time();
    }

    private function __clone() {}
}