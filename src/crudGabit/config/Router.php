<?php

namespace CrudGabit\Config;

use CrudGabit\Config\Request;
use CrudGabit\Config\Session;

class Router
{
    private array $rutasGET = [];
    private array $rutasPOST = [];
    private string $basePath;

    public function __construct(string $basePath = "")
    {
        if (empty($basePath)) {
            $basePath = dirname($_SERVER["SCRIPT_NAME"]);
        }
        $this->basePath = rtrim($basePath, "/");
    }

    /**
     * Registrar una ruta GET
     * @param string $ruta
     * @param array $controlador
     * @return void
     */
    public function get(string $ruta, array $controlador): void
    {
        $this->rutasGET[$ruta] = $controlador;
    }

    /**
     * Registrar una ruta POST
     * @param string $ruta
     * @param array $controlador
     * @return void
     */
    public function post(string $ruta, array $controlador): void
    {
        $this->rutasPOST[$ruta] = $controlador;
    }

    /**
     * Ejecutar el router: busca la ruta solicitada y ejecuta el controlador
     * @return void
     */
    public function run(): void
    {
        $metodo = $_SERVER["REQUEST_METHOD"];
        $url = $_SERVER["REQUEST_URI"];
        $url = strtok($url, "?");
        if (!empty($this->basePath) && str_starts_with($url, $this->basePath)) {
            $url = substr($url, strlen($this->basePath));
        }
        if (empty($url) || $url[0] !== "/") {
            $url = "/" . $url;
        }
        if ($url !== "/" && str_ends_with($url, "/")) {
            $url = rtrim($url, "/");
        }
        if ($metodo === "GET") {
            $this->ejecutarRuta($url, $this->rutasGET);
        } elseif ($metodo === "POST") {
            $this->ejecutarRuta($url, $this->rutasPOST);
        } else {
            $this->error404();
        }
    }

    /**
     * Buscar y ejecutar la ruta correspondiente
     * @param string $url
     * @param array $rutas
     * @return void
     */
    private function ejecutarRuta(string $url, array $rutas): void
    {
        if (isset($rutas[$url])) {
            $this->llamarControlador($rutas[$url]);
            return;
        }

        $this->error404();
    }

    /**
     * Llamar al método del controlador
     * @param array $controlador
     * @return void
     */
    private function llamarControlador(array $controlador): void
    {
        [$clase, $metodo] = $controlador;

        if (is_string($clase)) {
            $clase = new $clase();
        }

        $clase->$metodo();
    }

    /**
     * Mostrar error 404
     * @return void
     */
    private function error404(): void
    {
        http_response_code(404);
        Request::redirect("/dashboard");
        exit;
    }

    public static function protectAdmin($url): void
    {
        if (!Auth::checkRol()) {
            Request::redirect($url);
        }
    }

    public static function protectActive($url): void
    {
        if (!Session::active()) {
            Request::redirect($url);
        }
    }
}