<?php
    require_once "../libreria/layout.php";
    require_once "../libreria/controllUsuarios.php";
    require_once "../clases/Usuario.php";
    require_once "../conexiones/bbdd.php";
    require_once "../clases/Habito.php";

    $pdo = conectarBD();

    session_start();

    $usuarioActual = $_SESSION["usuarioActual"];
    $sql = "SELECT * FROM camino";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $habitos = $stmt->fetchAll(PDO::FETCH_CLASS, "Habito");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Hábitos - Gabit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/stylesDashboard.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
<?= mostrarNav($usuarioActual->getNombre()) ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Hábitos</h1>
        <a href="../dashboard.php" class="btn btn-outline-secondary">← Volver al Dashboard</a>
    </div>
    <div class="row mb-4">
        <div class="col-md-10 mx-auto">
            <form method="POST" class="card p-3 shadow-sm">
                <h5 class="mb-3">Buscar y Filtrar Hábitos</h5>
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="buscar" value="<?= $terminoBusqueda ?>" placeholder="Ingrese nombre o descripción">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="categoria">
                            <option value="">Todas las categorías</option>
                            <option value="Salud" <?= ($categoriaFiltro ?? '') == "Salud" ? "selected" : "" ?>>Salud</option>
                            <option value="Productividad" <?= ($categoriaFiltro ?? '') == "Productividad" ? "selected" : "" ?>>Productividad</option>
                            <option value="Bienestar" <?= ($categoriaFiltro ?? '') == "Bienestar" ? "selected" : "" ?>>Bienestar</option>
                            <option value="Aprendizaje" <?= ($categoriaFiltro ?? '') == "Aprendizaje" ? "selected" : "" ?>>Aprendizaje</option>
                            <option value="Social" <?= ($categoriaFiltro ?? '') == "Social" ? "selected" : "" ?>>Social</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">Filtrar</button>
                            <?php if(!empty($terminoBusqueda) || !empty($categoriaFiltro)): ?>
                                <a href="habitos.php" class="btn btn-outline-secondary">✕</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if(!empty($terminoBusqueda) || !empty($categoriaFiltro)): ?>
                    <small class="text-muted mt-2">
                        Mostrando <?= count($habitosFiltrados) ?> resultado(s)
                        <?php if(!empty($terminoBusqueda)): ?>
                            para "<?= $terminoBusqueda ?>"
                        <?php endif; ?>
                        <?php if(!empty($categoriaFiltro)): ?>
                            en categoría "<?= $categoriaFiltro ?>"
                        <?php endif; ?>
                    </small>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Formulario -->
        <div class="col-md-4">
            <form class="card p-4 shadow-sm" method="POST">
                <h4 class="mb-3">Formulario de Hábito</h4>

                <input type="hidden" name="idHabito" value="<?= $idActualizar ?>">

                <div class="mb-3">
                    <label class="form-label">Nombre del Hábito</label>
                    <input type="text" class="form-control" name="nombre" value="<?= $nombreActualizar ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" required><?= $descripcionActualizar ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select class="form-select" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="Salud" <?= $categoriaActualizar == "Salud" ? "selected" : "" ?>>Salud</option>
                        <option value="Productividad" <?= $categoriaActualizar == "Productividad" ? "selected" : "" ?>>Productividad</option>
                        <option value="Bienestar" <?= $categoriaActualizar == "Bienestar" ? "selected" : "" ?>>Bienestar</option>
                        <option value="Aprendizaje" <?= $categoriaActualizar == "Aprendizaje" ? "selected" : "" ?>>Aprendizaje</option>
                        <option value="Social" <?= $categoriaActualizar == "Social" ? "selected" : "" ?>>Social</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Autor</label>
                    <input class="form-control" name="autor" rows="3"  value="<?= $descripcionActualizar ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="guardar" class="btn btn-warning flex-fill">Actualizar</button>
                    <button type="submit" name="crear" class="btn btn-success flex-fill">Crear</button>
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h4 class="mb-3">Hábitos Registrados</h4>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Autor</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(empty($habitos)) {
                        echo "<tr><td colspan='7' class='text-center text-muted'>No se encontraron hábitos</td></tr>";
                    } else {
                        foreach ($habitos as $habito) {
                            $habito->mostrarHabito($habito);
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>