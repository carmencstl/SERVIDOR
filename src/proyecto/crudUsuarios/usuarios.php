<?php
    require_once "../libreria/layout.php";
    require_once "../libreria/controllUsuarios.php";
    require_once "../clases/Usuario.php";
    require_once "../conexiones/bbdd.php";
    require_once "../clases/BaseDatos.php";

    $baseDatos = BaseDatos::conectar();
    session_start();
    $usuarioActual = $_SESSION["usuarioActual"];

    $correoActualizar = "";
    $nombreUsuarioActualizar = "";
    $nombreActualizar = "";
    $apellidoActualizar = "";
    $rolActualizar = "usuario";

    $usuariosFiltrados = $baseDatos->todoUsuarios();

    #BORRAR USUARIO
    if (!empty($_POST["eliminar"])) {
        $correoEliminar = $_POST["eliminar"];
        $baseDatos->borrarUsuario($correoEliminar);
    }

    #CARGAR DATOS PARA ACTUALIZAR
    if (!empty($_POST["actualizar"])) {
        $correoActualizar = $_POST["actualizar"];
        $usuarioAEditar = $baseDatos->buscarUsuarioPorCorreo($correoActualizar);
        $nombreUsuarioActualizar = $usuarioAEditar->getNombreUsuario();
        $nombreActualizar = $usuarioAEditar->getNombre();
        $apellidoActualizar = $usuarioAEditar->getApellidos();
        $rolActualizar = $usuarioAEditar->getRol();
    }

    #ACTUALIZAR USUARIO
    $mensaje = "";

    if (isset($_POST["guardar"])) {
        $correoOriginal = $_POST["correoOriginal"];
        $nombreUsuarioActualizar = $_POST["nombreUsuarioActualizar"];
        $nombreActualizar = $_POST["nombreActualizar"];
        $apellidoActualizar = $_POST["apellidoActualizar"];
        $correoActualizar = $_POST["correoActualizar"];
        $rolActualizar = $_POST["rolActualizar"];
            $baseDatos->actualizarUsuario(
                    $correoOriginal,
                    $nombreUsuarioActualizar,
                    $nombreActualizar,
                    $apellidoActualizar,
                    $correoActualizar,
                    $rolActualizar
            );

        $mensaje = "✅ Usuario actualizado: $nombreUsuarioActualizar";
        $usuariosFiltrados = $baseDatos->todoUsuarios();
        $correoActualizar = "";
        $nombreUsuarioActualizar = "";
        $nombreActualizar = "";
        $apellidoActualizar = "";
        $rolActualizar = "usuario";
    }

    #CREAR USUARIO
    if (isset($_POST["crear"])) {
        $nombreUsuarioNuevo = $_POST["nombreUsuarioActualizar"];
        $nombreNuevo = $_POST["nombreActualizar"];
        $apellidosNuevo = $_POST["apellidoActualizar"];
        $correoNuevo = $_POST["correoActualizar"];
        $passwordNuevo = "password";
        $rolNuevo = $_POST["rolActualizar"];

        if($baseDatos->buscarUsuarioPorCorreo($correoNuevo) !== null) {
            $mensaje = "❌ Error: El correo ya está registrado.";
            $usuariosFiltrados = $baseDatos->todoUsuarios();
            $correoActualizar = "";
            $nombreUsuarioActualizar = "";
            $nombreActualizar = "";
            $apellidoActualizar = "";
            $rolActualizar = "usuario";
        }
        else {
            $nuevoUsuario = new Usuario(
                    $nombreUsuarioNuevo,
                    $nombreNuevo,
                    $apellidosNuevo,
                    $correoNuevo,
                    $passwordNuevo,
                    $rolNuevo
            );

            $baseDatos->insertarUsuario($nuevoUsuario);
            $mensaje = "✅ Usuario creado: $nombreUsuarioNuevo";
            $usuariosFiltrados = $baseDatos->todoUsuarios();
            $correoActualizar = "";
            $nombreUsuarioActualizar = "";
            $nombreActualizar = "";
            $apellidoActualizar = "";
            $rolActualizar = "usuario";
        }
    }

    #BUSCADOR
    $terminoBusqueda = $_POST["buscar"] ?? "";
    if(!empty($terminoBusqueda)) {
        $baseDatos->buscar($terminoBusqueda);
        $usuariosFiltrados = $baseDatos->todo();
    } else {
        $usuariosFiltrados = $baseDatos->todoUsuarios();
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
<?= mostrarNav($usuarioActual->getNombre()) ?>
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
                        Mostrando <?= count($usuariosFiltrados) ?> resultado(s) para "<?= $terminoBusqueda ?>"
                    </small>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?php if(!empty($mensaje)): ?>
                <div class="alert alert-<?= str_contains($mensaje, "❌") ? "danger" : "success" ?> mb-4" role="alert">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>
            <form class="card p-4 shadow-sm" method="POST">
                <h4 class="mb-3">Formulario de Usuario</h4>

                <input type="hidden" name="correoOriginal" value="<?= $correoActualizar ?>">

                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="nombreUsuarioActualizar" value="<?= $nombreUsuarioActualizar ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombreActualizar" value="<?= $nombreActualizar ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control" name="apellidoActualizar" value="<?= $apellidoActualizar ?>" required>
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
                            echo "<tr><td colspan='6' class='text-center text-muted'>No se encontraron usuarios</td></tr>";
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