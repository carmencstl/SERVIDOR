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
$idPadre = isset($_GET['idPadre']) && is_numeric($_GET['idPadre']) ? (int)$_GET['idPadre'] : null;

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

$usuario = [
    'idUsu' => $sesion->get('usuario_id'),
    'nombre' => $sesion->get('usuario_nombre'),
    'apellido' => $sesion->get('usuario_apellido')
];

// Máquina de estados
$estado = 'mostrar_form';
$errores = [];
$texto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = 'procesar_form';
}

switch ($estado) {
    case 'procesar_form':
        $texto = trim($_POST['texto'] ?? '');
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        
        // Validaciones
        if (empty($texto)) {
            $errores[] = 'El texto es obligatorio';
        }
        
        // Si no hay errores, insertar el comentario
        if (empty($errores)) {
            try {
                $sql = "INSERT INTO comentario (fecha, texto, idUsu, idArt, idPadre) 
                        VALUES (:fecha, :texto, :idUsu, :idArt, :idPadre)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':fecha', $fecha);
                $stmt->bindValue(':texto', $texto);
                $stmt->bindValue(':idUsu', $usuario['idUsu'], PDO::PARAM_INT);
                $stmt->bindValue(':idArt', $idArt, PDO::PARAM_INT);
                $stmt->bindValue(':idPadre', $idPadre, PDO::PARAM_INT);
                $stmt->execute();
                
                // Guardar mensaje de éxito en sesión
                $sesion->set('mensaje_exito', 'La operación se ha realizado con éxito');
                
                // Redirigir a leer el artículo
                header('Location: leer.php?idArt=' . $idArt);
                exit;
            } catch (PDOException $e) {
                error_log("Error al insertar comentario: " . $e->getMessage());
                header('Location: main.php');
                exit;
            }
        }
        break;
}

$esRespuesta = $idPadre !== null;
$tituloAccion = $esRespuesta ? 'Responder a comentario' : 'Escribir comentario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloAccion ?> - BlogiFy</title>
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
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3><i class="bi bi-chat-dots"></i> <?= $tituloAccion ?></h3>
                </div>
                <div class="card-body">
                    <!-- Información del artículo -->
                    <div class="alert alert-info">
                        <h5><?= htmlspecialchars($articulo['titulo']) ?></h5>
                        <p class="mb-0 text-muted">
                            <i class="bi bi-person"></i> <?= htmlspecialchars($articulo['nombre'] . ' ' . $articulo['apellido']) ?> | 
                            <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($articulo['fecha'])) ?>
                        </p>
                    </div>
                    
                    <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <input type="hidden" name="idArt" value="<?= $idArt ?>">
                        <?php if ($idPadre): ?>
                        <input type="hidden" name="idPadre" value="<?= $idPadre ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="texto" class="form-label">Texto *</label>
                            <textarea class="form-control" id="texto" name="texto" rows="8" required autofocus><?= htmlspecialchars($texto) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" 
                                   value="<?= date('Y-m-d') ?>" readonly>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Publicar
                            </button>
                            <a href="leer.php?idArt=<?= $idArt ?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
