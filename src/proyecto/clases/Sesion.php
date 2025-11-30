<?php


require_once "../clases/Request.php";

final class Sesion
{
    private static ?Sesion $instancia = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();

    require_once "clases/Usuario.php";
    final class Sesion {
        private static $instance = null;
        private ?Usuario $usuario;

        private function __construct() {
            session_start();
            if (isset($_SESSION["usuarioActivo"])) {
                $this->usuario = $_SESSION["usuarioActivo"];
            }
        }

        /**
         * @return void
         *
         */
        private function __clone() {}


        /**
         * @return Sesion
         *
         */
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new Sesion();
            }
            return self::$instance;
        }

        /**
         * @param Usuario $usuario
         * @return void
         *
         */
        public function iniciarSesion(Usuario $usuario) {
            $this->usuario = $usuario;
            $_SESSION["usuarioActivo"] = $usuario;
        }

        /**
         * @return void
         */
        public function cerrarSesion() {
            $this->usuario = null;
            session_destroy();
        }

        /**
         * @return bool
         */
        public function estaLogueado() {
            return $this->usuario !== null;
        }

        /**
         * @return Usuario|null
         */
        public function getUsuario() {
            return $this->usuario;                
        }
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new Exception("No se puede deserializar un Singleton");
    }

    public static function obtenerInstancia(): Sesion
    {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    // Método para iniciar sesión de usuario
    public static function login(array $usuario): void
    {
        self::obtenerInstancia();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['logueado'] = true;
    }

    // Método para verificar si hay sesión activa
    public static function estaLogueado(): bool
    {
        self::obtenerInstancia();
        return isset($_SESSION['logueado']) && $_SESSION['logueado'] === true;
    }

    // Método para obtener datos del usuario
    public static function obtenerUsuario(): ?array
    {
        self::obtenerInstancia();
        return $_SESSION['usuario'] ?? null;
    }

    // Método para establecer valores en sesión
    public static function set(string $clave, mixed $valor): void
    {
        self::obtenerInstancia();
        $_SESSION[$clave] = $valor;
    }

    // Método para obtener valores de sesión
    public static function get(string $clave): mixed
    {
        self::obtenerInstancia();
        return $_SESSION[$clave] ?? null;
    }

    /**
     * @return never
     */
    public static function cerrarSesion(): never
    {
        self::obtenerInstancia();
        $_SESSION = [];
        session_destroy();
        Request::redirect("login.php");
    }
}