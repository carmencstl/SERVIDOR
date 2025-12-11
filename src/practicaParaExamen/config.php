<?php

/**
 * Archivo de configuración general de la aplicación
 */

// Reportar todos los errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Europe/Madrid');

// Constantes de la aplicación
define('BASE_URL', 'http://localhost/blogify');
define('APP_NAME', 'BlogiFy');

// Incluir autoloader
require_once __DIR__ . '/autoload.php';

// Usar las clases necesarias
use Blogify\Database\Database;
use Blogify\Session\Sesion;

// Inicializar sesión
$sesion = Sesion::init();

// Obtener instancia de base de datos
$db = Database::getInstance();
$pdo = $db->getConnection();
