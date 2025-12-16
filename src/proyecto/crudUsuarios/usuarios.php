<?php

use config\BaseDatos;

require_once "../libreria/layout.php";
    require_once "../libreria/controllUsuarios.php";
    require_once "../clases/Usuario.php";
    require_once "../conexiones/bbdd.php";
    require_once "../clases/BaseDatos.php";
    require_once "../clases/Sesion.php";
    require_once "../clases/Request.php";

    $baseDatos = BaseDatos::conectar();
    $sesion = Sesion::getInstance();
    $usuarioActual = $sesion->obtenerUsuario();

    $mensaje = "";
    $usuarioEditar = null;
    $terminoBusqueda = $_POST["buscar"] ?? "";


    # ELIMINAR USUARIO
    if(isset($_POST["eliminar"])){
        Usuario::eliminarUsuario($_POST["eliminar"]);
        $mensaje = "✅ Usuario eliminado.";
        Request::redirect("usuarios.php");
    }

    # CARGAR DATOS PARA EDITAR
    if(isset($_POST["actualizar"])) {
        $usuarioEditar = Usuario::buscarPorEmail($_POST["actualizar"]);
    }

    # GUARDAR USUARIO (Crear o Actualizar)
    if(isset($_POST["guardar"]) || isset($_POST["crear"])) {
        $esActualizacion = isset($_POST["guardar"]);

        if($esActualizacion) {

            $usuario = Usuario::buscarPorEmail($_POST["correoOriginal"]);
            $usuario->setNombreUsuario($_POST["nombreUsuario"]);
            $usuario->setNombre($_POST["nombre"]);
            $usuario->setApellidos($_POST["apellidos"]);
            $usuario->setEmail($_POST["correo"]);
            $usuario->setRol($_POST["rol"]);
            $usuario->actualizarUsuario();

            $mensaje = "✅ Usuario actualizado: " . $_POST["nombreUsuario"];
        } else {

            if(Usuario::buscarPorEmail($_POST["correo"]) !== null) {
                $mensaje = "❌ Error: El correo ya está registrado.";
                $usuarioEditar = (object)[
                        'nombreUsuario' => $_POST["nombreUsuario"],
                        'nombre' => $_POST["nombre"],
                        'apellidos' => $_POST["apellidos"],
                        'email' => $_POST["correo"],
                        'rol' => $_POST["rol"]
                ];
            } else {
                $nuevoUsuario = new Usuario(
                        $_POST["nombreUsuario"],
                        $_POST["nombre"],
                        $_POST["apellidos"],
                        $_POST["correo"],
                        "password",
                        $_POST["rol"]
                );
                $nuevoUsuario->insertarUsuario();
                $mensaje = "✅ Usuario creado: " . $_POST["nombreUsuario"];
            }
        }
    }

    # Buscar o listar todos
    $usuariosFiltrados = !empty($terminoBusqueda)
            ? Usuario::devolverUsuarioPorFiltro($terminoBusqueda)
            : Usuario::devolverUsuarios();

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

    <!-- Buscador -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form method="POST" class="card p-3 shadow-sm">
                <h5 class="mb-3">Buscar Usuario</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" name="buscar"
                           value="<?= ($terminoBusqueda) ?>"
                           placeholder="Buscar...">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <?php if(!empty($terminoBusqueda)): ?>
                        <a href="usuarios.php" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
                <?php if(!empty($terminoBusqueda)): ?>
                    <small class="text-muted mt-2">
                        Mostrando <?= count($usuariosFiltrados) ?> resultado(s) para "<?= ($terminoBusqueda) ?>"
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
                <h4 class="mb-3">
                    <?= $usuarioEditar ? "Editar Usuario" : "Crear Usuario" ?>
                </h4>

                <?php if($usuarioEditar): ?>
                    <input type="hidden" name="correoOriginal" value="<?= $usuarioEditar->getEmail() ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="nombreUsuario"
                           value="<?= $usuarioEditar?->getNombreUsuario() ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre"
                           value="<?= $usuarioEditar?->getNombre() ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control" name="apellidos"
                           value="<?= $usuarioEditar?->getApellidos() ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="correo"
                           value="<?= $usuarioEditar?->getEmail() ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select class="form-select" name="rol">
                        <?php
                            $rolActual = $usuarioEditar?->getRol() ?? "usuario";
                        ?>
                        <option value="admin" <?= $rolActual == "admin" ? "selected" : "" ?>>Admin</option>
                        <option value="usuario" <?= $rolActual == "usuario" ? "selected" : "" ?>>Usuario</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <?php if($usuarioEditar): ?>
                        <button type="submit" name="guardar" class="btn btn-warning flex-fill">
                            Actualizar
                        </button>
                        <a href="usuarios.php" class="btn btn-outline-secondary flex-fill">
                            Cancelar
                        </a>
                    <?php else: ?>
                        <button type="submit" name="crear" class="btn btn-success w-100">
                            Crear Usuario
                        </button>
                    <?php endif; ?>
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
                    <?php if(empty($usuariosFiltrados)): ?>
                        <tr>
                            <td colspan='6' class='text-center text-muted'>
                                No se encontraron usuarios
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($usuariosFiltrados as $usuario): ?>
                            <?php mostrarDatos($usuario); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>