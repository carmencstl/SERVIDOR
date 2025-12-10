<?php
require_once 'config.php';

// Control de sesión
if (!$sesion->active()) {
    header('Location: index.php');
    exit;
}

// Verificar que se reciban los parámetros necesarios
if (!isset($_GET['idCom']) || !is_numeric($_GET['idCom']) || 
    !isset($_GET['idArt']) || !is_numeric($_GET['idArt'])) {
    header('Location: main.php');
    exit;
}

$idCom = (int)$_GET['idCom'];
$idArt = (int)$_GET['idArt'];
$usuarioId = $sesion->get('usuario_id');

try {
    // Verificar que el comentario existe y pertenece al usuario logueado
    $sql = "SELECT idCom, idUsu FROM comentario WHERE idCom = :idCom";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':idCom', $idCom, PDO::PARAM_INT);
    $stmt->execute();
    $comentario = $stmt->fetch();
    
    if (!$comentario) {
        // El comentario no existe
        header('Location: leer.php?idArt=' . $idArt);
        exit;
    }
    
    // Verificar que el comentario pertenece al usuario logueado
    if ($comentario['idUsu'] !== $usuarioId) {
        header('Location: leer.php?idArt=' . $idArt);
        exit;
    }
    
    // Eliminar el comentario (las respuestas se eliminan en cascada)
    $sql = "DELETE FROM comentario WHERE idCom = :idCom";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':idCom', $idCom, PDO::PARAM_INT);
    $stmt->execute();
    
    // Redirigir al artículo
    header('Location: leer.php?idArt=' . $idArt);
    exit;
    
} catch (PDOException $e) {
    error_log("Error al eliminar comentario: " . $e->getMessage());
    header('Location: leer.php?idArt=' . $idArt);
    exit;
}
