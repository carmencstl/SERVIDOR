<?php

require_once "./User.php";

if (isset($_POST) && !isset($_POST["eliminar"]) && !isset($_POST["actualizar"])) {

    $mensaje = "";
    $name = $_POST["name"];
    $apellidos = $_POST["apellidos"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(User::buscarPorEmail($email) !== null){
        $mensaje = "El usuario ya existe";
    }
    else{
        $usuario = new User(
                nombreUsuario: $username,
                nombre: $name,
                apellidos: $apellidos,
                email: $email,
                password: $password,
                rol: "usuario"
        );
        $usuario->insertarUsuario();
        $mensaje = "";
        $name = "";
        $apellidos = "";
        $email = "";
        $username = "";
        $password = "";
    }
}

    if(isset($_POST["eliminar"])){

        User::eliminarUsuario($_POST["eliminar"]);
    }

    if(isset($_POST["actualizar"])){
        $usuarioActualizar = User::buscarPorEmail($_POST["actualizar"]);
        $name = $usuarioActualizar->getNombre();
        $apellidos = $usuarioActualizar->getApellidos();
        $email = $usuarioActualizar->getEmail();
        $username = $usuarioActualizar->getNombreUsuario();
    }


$usuarios= User::devolverUsuarios();

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Registro</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required value= "<?php if(isset($_POST["actualizar"])){ echo $name; } else { echo $name ?? ""; }  ?>">
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required value= "<?php if(isset($_POST["actualizar"])){ echo $name; } else { echo ""; }  ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required value= "<?= $email ?? "" ?>">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required value= "<?= $username ?? "" ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                    <?php if (isset($mensaje) && $mensaje !== ""): ?>
                        <div class="alert alert-warning mt-3" role="alert">

                            <?php echo $mensaje; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row justify-content-center mt-4">
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
                    if(empty($usuarios)){
                        echo "<tr><td colspan=\"6\" class=\"text-center text-muted\">No se encontraron usuarios</td></tr>";
                    } else {
                        foreach ($usuarios as $usuario) {
                            $usuario->mostrarDatos($usuario);
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </main>
    </body>
    </html>