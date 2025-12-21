<?php
// 1. Iniciar sesión siempre antes de cargar clases
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

use CrudGabit\Config\Router;
use CrudGabit\Controladores\AuthController;
use CrudGabit\Config\Session;
use CrudGabit\Config\Request;
use CrudGabit\Controladores\DashboardController;

$router = new Router('/crudGabit');

// Rutas de Autenticación
$router->get("/", [AuthController::class, "showLogin"]);
$router->get("/login", [AuthController::class, "showLogin"]);
$router->post("/login", [AuthController::class, "login"]);
$router->get("/register", [AuthController::class, "showRegister"]);
$router->post("/register", [AuthController::class, "register"]);
$router->get("/logout", [AuthController::class, "logout"]);
$router->get("/dashboard" , [DashboardController::class, "showDashboard"]) ;


$router->run();