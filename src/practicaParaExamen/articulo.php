<?php
require_once 'config.php';

// Control de sesión
if (!$sesion->active()) {
    header('Location: index.php');
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
$titulo = '';
$texto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = 'procesar_form';
}

switch ($estado) {
    case 'procesar_form':
        $titulo = trim($_POST['titulo'] ?? '');
        $texto = trim($_POST['texto'] ?? '');
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        
        // Validaciones
        if (empty($titulo)) {
            $errores[] = 'El título es obligatorio';
        }
        if (empty($texto)) {
            $errores[] = 'El texto es obligatorio';
        }
        
        // Si no hay errores, insertar el artículo
        if (empty($errores)) {
            try {
                $sql = "INSERT INTO articulo (titulo, texto, positivos, negativos, fecha, idAut) 
                        VALUES (:titulo, :texto, 0, 0, :fecha, :idAut)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':texto', $texto);
                $stmt->bindValue(':fecha', $fecha);
                $stmt->bindValue(':idAut', $usuario['idUsu'], PDO::PARAM_INT);
                $stmt->execute();
                
                // Guardar mensaje de éxito en sesión
                $sesion->set('mensaje_exito', 'La operación se ha realizado con éxito');
                
                // Redirigir a main
                header('Location: main.php');
                exit;
            } catch (PDOException $e) {
                error_log("Error al insertar artículo: " . $e->getMessage());
                // En caso de error, redirigir sin mensaje
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
    <title>Escribir Artículo - BlogiFy</title>
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
        
        <main class="mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="bi bi-pencil-square"></i> Escribir un Artículo</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="articulo.php">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título *</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" 
                                   value="<?= htmlspecialchars($titulo) ?>" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label for="texto" class="form-label">Texto *</label>
                            <textarea class="form-control" id="texto" name="texto" rows="10" required><?= htmlspecialchars($texto) ?></textarea>
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
                            <a href="main.php" class="btn btn-secondary">
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
