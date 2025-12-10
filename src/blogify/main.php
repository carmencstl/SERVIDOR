<?php
require_once 'config.php';

// Control de sesión: redirigir si no está logueado
if (!$sesion->active()) {
    header('Location: index.php');
    exit;
}

// Obtener datos del usuario logueado
$usuario = [
    'idUsu' => $sesion->get('usuario_id'),
    'nombre' => $sesion->get('usuario_nombre'),
    'apellido' => $sesion->get('usuario_apellido'),
    'email' => $sesion->get('usuario_email')
];

// Obtener mensaje flash si existe
$mensaje = $sesion->get('mensaje_exito');
if ($mensaje) {
    $sesion->remove('mensaje_exito');
}

// Obtener todos los artículos
$sql = "SELECT a.*, u.nombre, u.apellido 
        FROM articulo a 
        INNER JOIN usuario u ON a.idAut = u.idUsu 
        ORDER BY a.fecha DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$articulos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - BlogiFy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@100;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Flex', sans-serif;
            font-weight: 100;
            background-color: #f8f9fa;
        }
        .table {
            font-family: 'Roboto Flex', sans-serif;
            font-weight: 100;
        }
        h1 {
            font-weight: 700;
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
        
        <main>
            <?php if ($mensaje): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($mensaje) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="row">
                    <div class="m-3">
                        <a href="./main.php" class="btn btn-dark">Inicio</a>
                        <a href="./articulo.php" class="btn btn-primary">Escribir un artículo</a>
                        <a href="./logout.php" class="btn btn-danger">Cerrar Sesión</a>
                    </div>
                    
                    <div class="m-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título del artículo</th>
                                    <th>Positivos</th>
                                    <th>Negativos</th>
                                    <th>Leer</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articulos as $articulo): ?>
                                <?php
                                    // Determinar si el artículo es del usuario logueado
                                    $esDelUsuario = $articulo['idAut'] === $usuario['idUsu'];
                                    $botonClass = $esDelUsuario ? 'btn btn-light' : 'btn btn-dark';
                                    $disabled = $esDelUsuario ? 'disabled' : '';
                                    
                                    // Formatear votos con ceros a la izquierda
                                    $positivos = str_pad($articulo['positivos'], 3, '0', STR_PAD_LEFT);
                                    $negativos = str_pad($articulo['negativos'], 3, '0', STR_PAD_LEFT);
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($articulo['titulo']) ?></td>
                                    <td>
                                        <?php if (!$esDelUsuario): ?>
                                        <a href="./masPositivo.php?idArt=<?= $articulo['idArt'] ?>" class="<?= $botonClass ?>">
                                            <i class="bi bi-hand-thumbs-up-fill"></i> <?= $positivos ?>
                                        </a>
                                        <?php else: ?>
                                        <span class="<?= $botonClass ?>">
                                            <i class="bi bi-hand-thumbs-up-fill"></i> <?= $positivos ?>
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!$esDelUsuario): ?>
                                        <a href="./masNegativo.php?idArt=<?= $articulo['idArt'] ?>" class="<?= $botonClass ?>">
                                            <i class="bi bi-hand-thumbs-down-fill"></i> <?= $negativos ?>
                                        </a>
                                        <?php else: ?>
                                        <span class="<?= $botonClass ?>">
                                            <i class="bi bi-hand-thumbs-down-fill"></i> <?= $negativos ?>
                                        </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="./leer.php?idArt=<?= $articulo['idArt'] ?>" class="btn btn-warning">
                                            <i class="bi bi-book-fill"></i> Leer
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($esDelUsuario): ?>
                                        <a href="./editarArticulo.php?idArt=<?= $articulo['idArt'] ?>" class="btn btn-warning">Editar</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($esDelUsuario): ?>
                                        <a href="./borrar.php?idArt=<?= $articulo['idArt'] ?>" class="btn btn-danger">Borrar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
