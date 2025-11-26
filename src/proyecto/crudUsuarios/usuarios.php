<?php
    require_once "../libreria/layout.php";
    require_once "../libreria/controllUsuarios.php";
    require_once "../clases/Usuario.php";
    require_once "../conexiones/bbdd.php";
    session_start();
    $pdo = conectarBD();
//
//    if (!empty($_POST["eliminar"])) {
//        $correoEliminar = $_POST["eliminar"];
//        deleteUser($correoEliminar);
//        header("Location: usuarios.php");
//
//    }

//    $nombreUsuarioActualizar = "";
//    $nombreActualizar = "";
//    $apellidoActualizar = "";
//    $correoActualizar = "";
//    $rolActualizar = "";
//
//    if (!empty($_POST["actualizar"])) {
//
//        $correoBuscado = $_POST["actualizar"];
//        $usuarioEncontrado = buscarUsuarioPorCorreo($correoBuscado);
//
//        if ($usuarioEncontrado) {
//            $nombreUsuarioActualizar = $usuarioEncontrado->getNombreUsuario();
//            $nombreActualizar = $usuarioEncontrado->getNombre();
//            $apellidoActualizar = $usuarioEncontrado->getApellido();
//            $correoActualizar = $usuarioEncontrado->getCorreo();
//            $rolActualizar = $usuarioEncontrado->getRol();
//        }
//    }

//    if (isset($_POST["guardar"])) {
//        actualizarUsuarioExistente($_POST["correoOriginal"],
//                $_POST["nombreActualizar"],
//                $_POST["correoActualizar"],
//                $_POST["rolActualizar"]);
//    }
//
//    if(isset($_POST["crear"])) {
//        crearNuevoUsuario($_POST["nombreActualizar"], $_POST["correoActualizar"]);
//    }

    $terminoBusqueda = "";
//    $usuariosFiltrados = $_SESSION["usuario"] ?? [];


if (isset($_POST["buscar"]) && !empty($_POST["buscar"])) {

    $terminoBusqueda = trim($_POST["buscar"]);
    $busqueda = "%{$terminoBusqueda}%";
    $sql = "SELECT * FROM usuario WHERE nombre LIKE :busqueda OR email LIKE :busqueda";
    $pdop = $pdo->prepare($sql);
    $pdop->bindParam(":busqueda", $busqueda);
    $pdop->bindParam(":busqueda", $busqueda);
    $pdop->execute();

} else {
    $usuariosFiltrados = $pdo->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Gabit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
<?= mostrarNav("user") ?>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Usuarios</h1>
        <a href="../dashboard.php" class="btn btn-outline-secondary">← Volver al Dashboard</a>
    </div>
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form method="POST" class="card p-3 shadow-sm">
                <h5 class="mb-3">Buscar Usuario</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" name="buscar" value="<?= $terminoBusqueda ?>" placeholder="Ingrese nombre o correo">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <?php if(!empty($terminoBusqueda)): ?>
                        <a href="usuarios.php" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
                <?php if(!empty($terminoBusqueda)): ?>
                    <small class="text-muted mt-2">
                        Mostrando <?= count($usuariosFiltrados) ?> resultado(s) para "<?= htmlspecialchars($terminoBusqueda) ?>"
                    </small>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <form class="card p-4 shadow-sm" method="POST">
                <h4 class="mb-3">Formulario de Usuario</h4>

                <input type="hidden" name="correoOriginal" value="<?= $correoActualizar ?>">

                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="nombreActualizar" value="<?= $nombreUsuarioActualizar ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombreActualizar" value="<?= $nombreActualizar ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control" name="nombreActualizar" value="<?= $ApellidoActualizar ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correoActualizar" value="<?= $correoActualizar ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select class="form-select" name="rolActualizar">
                        <option value="admin" <?= $rolActualizar == "admin" ? "selected" : "" ?>>Admin</option>
                        <option value="usuario" <?= $rolActualizar == "usuario" ? "selected" : "" ?>>Usuario</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="guardar" class="btn btn-warning flex-fill">Actualizar</button>
                    <button type="submit" name="crear" class="btn btn-success flex-fill">Crear</button>
                </div>
            </form>
        </div>

        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h4 class="mb-3">Usuarios Registrados</h4>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(empty($usuariosFiltrados)) {
                            echo "<tr><td colspan='4' class='text-center text-muted'>No se encontraron usuarios</td></tr>";
                        } else {
                            foreach ($usuariosFiltrados as $usuario) {
                                mostrarDatos($usuario);
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