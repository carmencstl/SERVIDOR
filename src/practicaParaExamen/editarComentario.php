<?php
require_once 'config.php';

// Control de sesión
if (!$sesion->active()) {
    header('Location: index.php');
    exit;
}

// Verificar que se reciba el ID del comentario
if (!isset($_GET['idCom']) || !is_numeric($_GET['idCom'])) {
    header('Location: main.php');
    exit;
}

$idCom = (int)$_GET['idCom'];
$usuarioId = $sesion->get('usuario_id');

// Obtener el comentario
$sql = "SELECT c.*, a.titulo, a.fecha as fechaArt, u.nombre as nombreArt, u.apellido as apellidoArt
        FROM comentario c 
        INNER JOIN articulo a ON c.idArt = a.idArt
        INNER JOIN usuario u ON a.idAut = u.idUsu
        WHERE c.idCom = :idCom";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':idCom', $idCom, PDO::PARAM_INT);
$stmt->execute();
$comentario = $stmt->fetch();

if (!$comentario) {
    header('Location: main.php');
    exit;
}

// Verificar que el comentario pertenece al usuario logueado
if ($comentario['idUsu'] !== $usuarioId) {
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
$texto = $comentario['texto'];
$fecha = $comentario['fecha'];

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
        
        // Si no hay errores, actualizar el comentario
        if (empty($errores)) {
            try {
                $sql = "UPDATE comentario 
                        SET texto = :texto, fecha = :fecha 
                        WHERE idCom = :idCom";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':texto', $texto);
                $stmt->bindValue(':fecha', $fecha);
                $stmt->bindValue(':idCom', $idCom, PDO::PARAM_INT);
                $stmt->execute();
                
                // Guardar mensaje de éxito en sesión
                $sesion->set('mensaje_exito', 'La operación se ha realizado con éxito');
                
                // Redirigir al artículo
                header('Location: leer.php?idArt=' . $comentario['idArt']);
                exit;
            } catch (PDOException $e) {
                error_log("Error al actualizar comentario: " . $e->getMessage());
                header('Location: main.php');
                exit;
            }
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Comentario - BlogiFy</title>
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
                <div class="card-header bg-warning">
                    <h3><i class="bi bi-pencil-square"></i> Editar Comentario</h3>
                </div>
                <div class="card-body">
                    <!-- Información del artículo -->
                    <div class="alert alert-info">
                        <h5><?= htmlspecialchars($comentario['titulo']) ?></h5>
                        <p class="mb-0 text-muted">
                            <i class="bi bi-person"></i> <?= htmlspecialchars($comentario['nombreArt'] . ' ' . $comentario['apellidoArt']) ?> | 
                            <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($comentario['fechaArt'])) ?>
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
                        <div class="mb-3">
                            <label for="texto" class="form-label">Texto *</label>
                            <textarea class="form-control" id="texto" name="texto" rows="8" required autofocus><?= htmlspecialchars($texto) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" 
                                   value="<?= $fecha ?>" readonly>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Actualizar
                            </button>
                            <a href="leer.php?idArt=<?= $comentario['idArt'] ?>" class="btn btn-secondary">
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
