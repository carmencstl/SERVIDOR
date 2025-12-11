<?php
require_once 'config.php';

// Control de sesión
if (!$sesion->active()) {
    header('Location: index.php');
    exit;
}

// Verificar que se reciba el ID del artículo
if (!isset($_GET['idArt']) || !is_numeric($_GET['idArt'])) {
    header('Location: main.php');
    exit;
}

$idArt = (int)$_GET['idArt'];

try {
    // Verificar que el artículo existe
    $sql = "SELECT idArt, idAut FROM articulo WHERE idArt = :idArt";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':idArt', $idArt, PDO::PARAM_INT);
    $stmt->execute();
    $articulo = $stmt->fetch();
    
    if (!$articulo) {
        // El artículo no existe
        header('Location: main.php');
        exit;
    }
    
    // Verificar que el usuario no esté votando su propio artículo
    if ($articulo['idAut'] === $sesion->get('usuario_id')) {
        header('Location: main.php');
        exit;
    }
    
    // Incrementar votos negativos
    $sql = "UPDATE articulo SET negativos = negativos + 1 WHERE idArt = :idArt";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':idArt', $idArt, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirigir a la página principal
    header('Location: main.php');
    exit;
    
} catch (PDOException $e) {
    error_log("Error al incrementar votos negativos: " . $e->getMessage());
    header('Location: main.php');
    exit;
}
