<?php

/**
 * Autoloader simple para cargar clases automáticamente
 */
spl_autoload_register(function ($class) {
    // Convertir namespace a ruta de archivo
    // Ejemplo: Blogify\Database\Database -> database/Database.php
    
    $prefix = 'Blogify\\';
    $base_dir = __DIR__ . '/';
    
    // Si la clase no usa nuestro namespace, salir
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Obtener el nombre relativo de la clase
    $relative_class = substr($class, $len);
    
    // Convertir namespace a ruta de archivo (en minúsculas para las carpetas)
    $parts = explode('\\', $relative_class);
    $className = array_pop($parts); // Última parte es el nombre de la clase
    
    // Las carpetas en minúsculas
    $folders = array_map('strtolower', $parts);
    $folders[] = $className; // Añadir el nombre de la clase al final
    
    $file = $base_dir . implode('/', $folders) . '.php';
    
    // Si el archivo existe, cargarlo
    if (file_exists($file)) {
        require $file;
    }
});
