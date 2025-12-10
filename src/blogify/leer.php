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

// Obtener el artículo
$sql = "SELECT a.*, u.nombre, u.apellido 
        FROM articulo a 
        INNER JOIN usuario u ON a.idAut = u.idUsu 
        WHERE a.idArt = :idArt";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':idArt', $idArt, PDO::PARAM_INT);
$stmt->execute();
$articulo = $stmt->fetch();

if (!$articulo) {
    header('Location: main.php');
    exit;
}

// Obtener comentarios del artículo
$sql = "SELECT c.*, u.nombre, u.apellido 
        FROM comentario c 
        INNER JOIN usuario u ON c.idUsu = u.idUsu 
        WHERE c.idArt = :idArt 
        ORDER BY c.fecha ASC, c.idCom ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':idArt', $idArt, PDO::PARAM_INT);
$stmt->execute();
$comentarios = $stmt->fetchAll();

// Organizar comentarios por padre
$comentariosPrincipales = [];
$respuestas = [];

foreach ($comentarios as $comentario) {
    if ($comentario['idPadre'] === null) {
        $comentariosPrincipales[] = $comentario;
    } else {
        $respuestas[$comentario['idPadre']][] = $comentario;
    }
}

$usuario = [
    'idUsu' => $sesion->get('usuario_id'),
    'nombre' => $sesion->get('usuario_nombre'),
    'apellido' => $sesion->get('usuario_apellido')
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($articulo['titulo']) ?> - BlogiFy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@100;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Flex', sans-serif;
            background-color: #f8f9fa;
        }
        h1 { font-weight: 700; }
        .respuesta-comentario {
            margin-left: 40px;
            border-left: 3px solid #dee2e6;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="mt-4">
            <h1>BlogiFy ⋅.˳˳.⋅ॱ˙˙ॱ⋅.˳˳.⋅ॱ˙˙ॱᐧ.˳˳.⋅</h1>
            <p>
                <?= htmlspecialchars($usuario['nombre'] . " " . $usuario['apellido']) ?>, 2DAW<br />
                curso 2024|25
            </p>
        </header>
        
        <main class="mt-4">
            <div class="mb-3">
                <a href="main.php" class="btn btn-dark">
                    <i class="bi bi-arrow-left"></i> Volver al inicio
                </a>
            </div>
            
            <!-- Artículo -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0"><?= htmlspecialchars($articulo['titulo']) ?></h2>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <i class="bi bi-person"></i> <?= htmlspecialchars($articulo['nombre'] . ' ' . $articulo['apellido']) ?> | 
                        <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($articulo['fecha'])) ?>
                    </p>
                    <div class="article-text">
                        <?= nl2br(htmlspecialchars($articulo['texto'])) ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="comentario.php?idArt=<?= $articulo['idArt'] ?>" class="btn btn-success">
                        <i class="bi bi-chat-dots"></i> Escribir comentario
                    </a>
                </div>
            </div>
            
            <!-- Comentarios -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="h5 mb-0"><i class="bi bi-chat-left-text"></i> Comentarios</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($comentariosPrincipales)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay comentarios aún. ¡Sé el primero en comentar!
                    </div>
                    <?php else: ?>
                        <?php foreach ($comentariosPrincipales as $comentario): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong><?= htmlspecialchars($comentario['nombre'] . ' ' . $comentario['apellido']) ?></strong>
                                        <small class="text-muted ms-2">
                                            <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($comentario['fecha'])) ?>
                                        </small>
                                    </div>
                                    <div>
                                        <?php if ($comentario['idUsu'] === $usuarioId): ?>
                                        <a href="editarComentario.php?idCom=<?= $comentario['idCom'] ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <a href="borrarComentario.php?idCom=<?= $comentario['idCom'] ?>&idArt=<?= $idArt ?>" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Borrar
                                        </a>
                                        <?php else: ?>
                                        <a href="comentario.php?idArt=<?= $articulo['idArt'] ?>&idPadre=<?= $comentario['idCom'] ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-reply"></i> Responder
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p class="mb-0"><?= nl2br(htmlspecialchars($comentario['texto'])) ?></p>
                            </div>
                        </div>
                        
                        <!-- Respuestas al comentario -->
                        <?php if (isset($respuestas[$comentario['idCom']])): ?>
                            <?php foreach ($respuestas[$comentario['idCom']] as $respuesta): ?>
                            <div class="card mb-3 respuesta-comentario">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong><?= htmlspecialchars($respuesta['nombre'] . ' ' . $respuesta['apellido']) ?></strong>
                                            <small class="text-muted ms-2">
                                                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($respuesta['fecha'])) ?>
                                            </small>
                                        </div>
                                        <div>
                                            <?php if ($respuesta['idUsu'] === $usuarioId): ?>
                                            <a href="editarComentario.php?idCom=<?= $respuesta['idCom'] ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <a href="borrarComentario.php?idCom=<?= $respuesta['idCom'] ?>&idArt=<?= $idArt ?>" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Borrar
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p class="mb-0"><?= nl2br(htmlspecialchars($respuesta['texto'])) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
