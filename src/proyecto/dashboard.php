<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gabit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesDashboard.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">🏔️ Gabit Dashboard</span>
        <div class="d-flex align-items-center gap-3">
            <span class="navbar-text">Hola, <?= "user" ?></span>
            <a href="login.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container container-main">
    <h1 class="mb-4">Panel de Control</h1>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <h3><?= 2 ?></h3>
                <p>Usuarios registrados</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <h3><?= 3?></h3>
                <p>Paths creados</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <h3><?= 3 ?></h3>
                <p>Misiones activas</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <h3><?= 5 ?></h3>
                <p>Logros disponibles</p>
            </div>
        </div>
    </div>

    <!-- Menú de gestión -->
    <h2 class="mb-4">Gestión</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="crudUsuarios/usuarios.php" class="menu-card">
                <div class="menu-icon">👥</div>
                <h4>Usuarios</h4>
                <p>Gestionar usuarios y administradores</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="paths.php" class="menu-card">
                <div class="menu-icon">🎯</div>
                <h4>Hábitos (Paths)</h4>
                <p>Crear y editar paths, levels y missions</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="logros.php" class="menu-card">
                <div class="menu-icon">🏆</div>
                <h4>Logros</h4>
                <p>Administrar achievements y recompensas</p>
            </a>
        </div>
    </div>
</div>
</body>
</html>