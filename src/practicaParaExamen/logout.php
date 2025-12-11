<?php
require_once 'config.php';

// Destruir la sesión
$sesion->destroy();

// Redirigir al login
header('Location: index.php');
exit;
