<?php
require_once "conexiones/bbdd.php";
require_once "libreria/controllUsuarios.php";
require_once "clases/Usuario.php";
require_once "clases/Request.php";

session_start();

    $pdo = conectarBD();
    $_SESSION["usuarioActual"] = $_SESSION["usuarioActual"] ?? null;
    $mensaje = "";

if(empty($_SESSION["usuarioActual"])){
    if(!empty($_POST)){

        $nombreUsuario = $_POST["nombreUsuario"] ?? "";
        $nombre = $_POST["nombre"] ?? "";
        $correo = $_POST["correo"] ?? "";
        $apellidos = $_POST["apellidos"] ?? "";
        $password = $_POST["password"] ?? "";

        if (verificarUsuarioExistente($_POST["correo"])){
            $mensaje = "El usuario o correo ya se encuentra registrado";
        }
        else{
            $nuevoUsuario = new Usuario($nombreUsuario, $nombre, $apellidos, $correo, $password);
            agregarUsuario($nuevoUsuario);
            $mensaje = "Usuario agregado correctamente";
        }
    }
}
else{
        Request::redirect("dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gabit Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesLogin.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="login-card">
    <div class="logo">
    </div>

    <h1>Dashboard Admin</h1>
    <p class="subtitle">Gestiona Gabit</p>

    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Tu nombre">
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control form-control-lg" id="apellidos" name="apellidos" placeholder="Apellidos">
        </div>
        <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control form-control-lg" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre de usuario">
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control form-control-lg" id="correo" name="correo"
                   placeholder="tu@email.com" required autofocus
                   pattern="^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$"
                   title="Introduce un correo válido, por ejemplo: usuario@dominio.com">
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control form-control-lg" id="password" name="password"
                   placeholder="Tu contraseña" required /* pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$ *\"
            title="Mínimo 8 caracteres: mayúscula, minúscula, número y carácter especial (@$!%*?&)">
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100">Registrarse</button>
        <div class="mt-3 text-center">
            <a href="login.php">Iniciar Sesión</a>
        </div>
        <div class="mt-3 text-center text-danger ">
            <?php echo $mensaje; ?>
        </div>
    </form>
</div>
</body>
</html>