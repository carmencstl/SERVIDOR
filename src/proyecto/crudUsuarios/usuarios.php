<?php
require_once "../libreria/controllUsuarios.php";
require_once "../clases/Usuario.php";
session_start();

    if (isset($_POST['eliminar'])) {
        $correoEliminar = $_POST['eliminar'];
        deleteUser($correoEliminar);
        header("Location: usuarios.php");
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
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a href="../dashboard.php" class="navbar-brand">🏔️ Gabit Dashboard</a>
            <div class="d-flex align-items-center gap-3">
                <span class="navbar-text"><?= "user" ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Usuarios</h1>
            <a href="../dashboard.php" class="btn btn-outline-secondary">← Volver al Dashboard</a>
        </div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usuarios = $_SESSION["usuario"] ?? [];
                    foreach ($usuarios as $usuario) {
                        echo "<tr>";
                        echo "<td>" . ($usuario->getNombre()) . "</td>";
                        echo "<td>" . ($usuario->getCorreo()) . "</td>";
                        echo "<td>" . ($usuario->getRol()) . "</td>";
                        echo "<td>";
                        echo "<button class='m-lg-1 btn btn-sm btn-primary' onclick=\"updateUser()\">Actualizar</button>";
                        echo "<form method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='eliminar' value='" . $usuario->getcorreo() . "'>";
                        echo "<button type='submit' class='m-1 btn btn-sm btn-danger'>Eliminar</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
</body>
</html>