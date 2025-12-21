<?php

namespace CrudGabit\Config;

/**
 * Clase Router - Sistema de enrutamiento con Pretty URLs
 * Detecta automáticamente el basePath
 */
class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = "")
    {
        // Detectar basePath automáticamente si no se proporciona
        if (empty($basePath)) {
            $basePath = dirname($_SERVER["SCRIPT_NAME"]);

            // Si está en la raíz, dirname devuelve '/' o '\'
            if ($basePath === "/crudGabit" || $basePath === '\\crudGabit') {
                $basePath = "/crudGabit";
            }
        }

        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Registrar ruta GET
     * @param string $path
     * @param mixed $handler
     * @return void
     */
    public function get(string $path, $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Registrar ruta POST
     * @param string $path
     * @param mixed $handler
     * @return void
     */
    public function post(string $path, $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Añadir ruta al sistema
     * @param string $method
     * @param string $path
     * @param mixed $handler
     * @return void
     */
    private function addRoute(string $method, string $path, $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    /**
     * Ejecutar el router
     * @return void
     */
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Eliminar query string
        $uri = strtok($uri, '?');

        // Eliminar basePath de la URI
        if (!empty($this->basePath) && str_starts_with($uri, $this->basePath)) {
            $uri = substr($uri, strlen($this->basePath));
        }

        // Asegurar que empieza con /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        // Eliminar trailing slash (excepto /)
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        // Buscar ruta exacta
        if (isset($this->routes[$method][$uri])) {
            $this->execute($this->routes[$method][$uri]);
            return;
        }

        // Buscar ruta con parámetros
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = $this->convertToRegex($route);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->execute($handler, $matches);
                return;
            }
        }

        // 404
        $this->notFound();
    }

    /**
     * Convertir ruta a expresión regular
     * @param string $route
     * @return string
     */
    private function convertToRegex(string $route): string
    {
        $route = preg_replace('/\{id\}/', '(\d+)', $route);
        $route = preg_replace('/\{slug\}/', '([a-z0-9-]+)', $route);
        $route = preg_replace('/\{(\w+)\}/', '([^/]+)', $route);

        return '#^' . $route . '$#';
    }

    /**
     * Ejecutar handler de ruta
     * @param mixed $handler
     * @param array $params
     * @return void
     */
    private function execute($handler, array $params = []): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_array($handler) && count($handler) === 2) {
            [$controller, $method] = $handler;

            if (is_string($controller)) {
                $controller = new $controller();
            }

            call_user_func_array([$controller, $method], $params);
            return;
        }
    }

    /**
     * Página 404
     * @return void
     */
    private function notFound(): void
    {
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        exit;
    }

    /**
     * Redirigir a una URL
     * @param string $path
     * @return void
     */
    public static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }
}