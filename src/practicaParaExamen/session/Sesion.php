<?php

namespace Blogify\Session;

/**
 * Clase para gestionar las sesiones de usuario
 * Implementa el patrón Singleton
 * Incluye protección contra CSRF y expiración de sesión
 */
class Sesion
{
    private static $instance = null;
    private const SESSION_TIMEOUT = 300; // 5 minutos en segundos
    
    /**
     * Constructor privado para evitar instanciación directa
     */
    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            
            // Inicializar control de tiempo si no existe
            if (!isset($_SESSION['last_activity'])) {
                $_SESSION['last_activity'] = time();
            }
            
            // Generar token CSRF si no existe
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        }
    }
    
    /**
     * Previene la clonación del objeto
     */
    private function __clone() {}
    
    /**
     * Previene la deserialización del objeto
     */
    public function __wakeup()
    {
        throw new \Exception("No se puede deserializar un singleton");
    }
    
    /**
     * Inicia la sesión y devuelve una instancia de la clase Sesion
     * @return Sesion
     */
    public static function init()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Guarda en la sesión un valor bajo la clave indicada
     * @param string $clave Clave para almacenar el valor
     * @param mixed $valor Valor a guardar
     */
    public function set($clave, $valor)
    {
        $_SESSION[$clave] = $valor;
        // Actualizar el tiempo de última actividad
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Recupera de la sesión el valor de la clave dada
     * @param string $clave Clave del valor a recuperar
     * @return mixed Valor almacenado o null si no existe
     */
    public function get($clave)
    {
        return $_SESSION[$clave] ?? null;
    }
    
    /**
     * Devuelve true si la sesión está activa o false si no se ha iniciado o ha expirado
     * @return bool
     */
    public function active()
    {
        // Verificar si la sesión está iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }
        
        // Verificar si existe el tiempo de última actividad
        if (!isset($_SESSION['last_activity'])) {
            return false;
        }
        
        // Verificar si ha expirado (más de 5 minutos de inactividad)
        if (time() - $_SESSION['last_activity'] > self::SESSION_TIMEOUT) {
            $this->destroy();
            return false;
        }
        
        // Actualizar el tiempo de última actividad
        $_SESSION['last_activity'] = time();
        
        // Verificar si hay un usuario logueado
        return isset($_SESSION['usuario_id']);
    }
    
    /**
     * Destruye la sesión completamente
     */
    public function destroy()
    {
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }
    
    /**
     * Verifica si existe una clave en la sesión
     * @param string $clave Clave a verificar
     * @return bool
     */
    public function has($clave)
    {
        return isset($_SESSION[$clave]);
    }
    
    /**
     * Elimina una clave específica de la sesión
     * @param string $clave Clave a eliminar
     */
    public function remove($clave)
    {
        if (isset($_SESSION[$clave])) {
            unset($_SESSION[$clave]);
        }
    }
    
    /**
     * Genera un nuevo token CSRF
     * @return string Token generado
     */
    public function generateCsrfToken()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
    
    /**
     * Obtiene el token CSRF actual
     * @return string|null
     */
    public function getCsrfToken()
    {
        return $_SESSION['csrf_token'] ?? null;
    }
    
    /**
     * Verifica un token CSRF
     * @param string $token Token a verificar
     * @return bool
     */
    public function verifyCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Regenera el ID de sesión (útil después del login)
     */
    public function regenerate()
    {
        session_regenerate_id(true);
    }
}
