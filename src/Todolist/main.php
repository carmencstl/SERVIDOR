<?php

  /**
	 * Desarrollo web en Entorno Servidor
	 * Todo List
	 * Antonio J. Sánchez 
	 */

  require_once "autoload.php" ;
  require_once "./libreria/database.php" ;

use clases\Sesion;
use Practicas\src\Request;

session_start();

  if (!isset($_SESSION["usuarioConectado"])):
	Request::redirect("index.php");
  endif;

  if (time()-$_SESSION["tiempo"]>3600*2):
	Sesion::cerrarSesion("cerrar.php");
  endif;

  $_SESSION["tiempo"]=time(); //para que se refresque el tiempo si el usuario esta trabajando

	$db=\Clases\BaseDatos::conectar();
	$db->consulta();

      $sql = "SELECT * FROM Tarea WHERE idUsuario=$usuarioConectado->idUsuario;" ;
	  $resultados=$pdo->query($sql);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List - CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .categoria-trabajo { background-color: #0d6efd; }
        .categoria-personal { background-color: #198754; }
        .categoria-estudios { background-color: #ffc107; color: #000; }
        .categoria-hogar { background-color: #dc3545; }
        .categoria-otros { background-color: #6c757d; }
        .tarea-completada {
            text-decoration: line-through;
            opacity: 0.6;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0">Bienvenido, <span class="text-primary"><?php echo $_SESSION["usuarioConectado"]->nombreUsuario; ?></span></h2>
                        <p class="text-muted mb-0">Gestiona tus tareas diarias</p>
                    </div>
                    <a href="cerrar.php" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </a>
                </div>
            </div>

            <!-- Barra de búsqueda y filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row g-3">
                            <!-- Buscador -->
                            <div class="col-md-5">
                                <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                    <input type="text" class="form-control" name="buscar" placeholder="Buscar tareas..." value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">
                                </div>
                            </div>
                            <!-- Filtro por categoría -->
                            <div class="col-md-3">
                                <select class="form-select" name="categoria">
                                    <option value="">📂 Todas las categorías</option>
                                    <option value="trabajo" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'trabajo') ? 'selected' : ''; ?>>🏢 Trabajo</option>
                                    <option value="personal" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'personal') ? 'selected' : ''; ?>>👤 Personal</option>
                                    <option value="estudios" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'estudios') ? 'selected' : ''; ?>>📚 Estudios</option>
                                    <option value="hogar" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'hogar') ? 'selected' : ''; ?>>🏠 Hogar</option>
                                    <option value="otros" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'otros') ? 'selected' : ''; ?>>📌 Otros</option>
                                </select>
                            </div>
                            <!-- Filtro por estado -->
                            <div class="col-md-2">
                                <select class="form-select" name="estado">
                                    <option value="">📋 Todas</option>
                                    <option value="0" <?php echo (isset($_GET['estado']) && $_GET['estado'] == '0') ? 'selected' : ''; ?>>⏳ Pendientes</option>
                                    <option value="1" <?php echo (isset($_GET['estado']) && $_GET['estado'] == '1') ? 'selected' : ''; ?>>✅ Completadas</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulario Nueva Tarea -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Tarea</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="crear_tarea.php">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="2" required placeholder="Describe tu tarea..."></textarea>
                            </div>
                            <div class="col-md-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="">Selecciona...</option>
                                    <option value="trabajo">🏢 Trabajo</option>
                                    <option value="personal">👤 Personal</option>
                                    <option value="estudios">📚 Estudios</option>
                                    <option value="hogar">🏠 Hogar</option>
                                    <option value="otros">📌 Otros</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-lg"></i> Añadir Tarea
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de tareas -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-list-check"></i> Mis Tareas</h5>
                    <span class="badge bg-light text-dark">
                            <?php
                            // echo count($tareas);
                            ?>
                            tareas
                        </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Descripción</th>
                                <th style="width: 140px;">Categoría</th>
                                <th style="width: 120px;">Estado</th>
                                <th style="width: 200px;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Ejemplo de iteración sobre tareas
                            /*
                            foreach ($tareas as $tarea) {
                                $claseCompletada = $tarea->completada ? 'tarea-completada' : '';
                                $badgeEstado = $tarea->completada ? 'bg-success' : 'bg-warning';
                                $textoEstado = $tarea->completada ? '✅ Completada' : '⏳ Pendiente';

                                echo "<tr>";
                                echo "<td class='align-middle'>{$tarea->id}</td>";
                                echo "<td class='align-middle {$claseCompletada}'>{$tarea->descripcion}</td>";
                                echo "<td class='align-middle'>";
                                echo "<span class='badge categoria-{$tarea->categoria}'>";
                                // Aquí añadir icono según categoría
                                echo ucfirst($tarea->categoria);
                                echo "</span>";
                                echo "</td>";
                                echo "<td class='align-middle'>";
                                echo "<span class='badge {$badgeEstado}'>{$textoEstado}</span>";
                                echo "</td>";
                                echo "<td class='align-middle'>";

                                // Botón editar
                                echo "<button class='btn btn-sm btn-info' data-bs-toggle='modal' data-bs-target='#modalEditar{$tarea->id}' title='Editar'>";
                                echo "<i class='bi bi-pencil'></i>";
                                echo "</button> ";

                                // Botón cambiar estado
                                if (!$tarea->completada) {
                                    echo "<a href='completar_tarea.php?id={$tarea->id}' class='btn btn-sm btn-success' title='Completar'>";
                                    echo "<i class='bi bi-check-lg'></i>";
                                    echo "</a> ";
                                } else {
                                    echo "<a href='reactivar_tarea.php?id={$tarea->id}' class='btn btn-sm btn-warning' title='Reactivar'>";
                                    echo "<i class='bi bi-arrow-counterclockwise'></i>";
                                    echo "</a> ";
                                }

                                // Botón eliminar
                                echo "<button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#modalEliminar{$tarea->id}' title='Eliminar'>";
                                echo "<i class='bi bi-trash'></i>";
                                echo "</button>";

                                echo "</td>";
                                echo "</tr>";
                            }
                            */
                            ?>

                            <!-- Ejemplos estáticos -->
                            <tr>
                                <td class="align-middle">1</td>
                                <td class="align-middle">Completar proyecto de clase</td>
                                <td class="align-middle">
                                    <span class="badge categoria-estudios">📚 Estudios</span>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-warning">⏳ Pendiente</span>
                                </td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalEditar1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="completar_tarea.php?id=1" class="btn btn-sm btn-success" title="Completar">
                                        <i class="bi bi-check-lg"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar1" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-middle">2</td>
                                <td class="align-middle tarea-completada">Hacer la compra semanal</td>
                                <td class="align-middle">
                                    <spa
