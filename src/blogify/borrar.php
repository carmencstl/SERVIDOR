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
$usuarioId = $sesion->get('usuario_id');

try {
    // Verificar que el artículo existe y pertenece al usuario logueado
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
    
    // Verificar que el artículo pertenece al usuario logueado
    if ($articulo['idAut'] !== $usuarioId) {
        header('Location: main.php');
        exit;
    }
    
    // Eliminar el artículo (los comentarios se eliminan en cascada)
    $sql = "DELETE FROM articulo WHERE idArt = :idArt";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':idArt', $idArt, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirigir a la página principal
    header('Location: main.php');
    exit;
    
} catch (PDOException $e) {
    error_log("Error al eliminar artículo: " . $e->getMessage());
    header('Location: main.php');
    exit;
}
