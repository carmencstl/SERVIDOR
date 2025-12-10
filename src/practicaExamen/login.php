<?php

use Practicas\src\Sesion;

require_once "clases/Sesion.php";
    require_once "clases/DataBase.php";
    require_once "clases/Request.php";

    $sesion = Sesion::init();
    $baseDatos = DataBase::conectar();

    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";


    if(!empty($_POST)){
        if($baseDatos->autenticarUsuario($email, $password))
        {
            $usuario = $baseDatos->buscarUsuarioPorCorreo($email);
            $sesion->set("usuarioActivo", $usuario);
            Request::redirect("index.php");
        } else {
            $mensaje = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    }

   ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login Blogify</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Login</h5>
                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">ENTRAR EN BLOGIFY</button>
                        </div>
                    </form>
                    <?php if(isset($mensaje)): ?>
                        <div class="alert alert-danger mt-3"><?= $mensaje ?></div>
                    <?php endif ; ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>