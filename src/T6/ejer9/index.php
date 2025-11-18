<?php
    require_once "Categoria.php";
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="mostrarProducto.php">Mostrar productos</a>
          </li>
            <li class="nav-item">
                <a class="nav-link" href="resetSesion.php">Cerrar Sesión</a>
            </li>
        </ul>
      </div>
  </nav>
  <div class="container py-5">
          <div class="card-body">
            <form method="post" action="mostrarProducto.php">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required autofocus>
              </div>
              <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" id="precio"  name="precio" required>
              </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria" required name="categoria">
                        <option value="">Selecciona una opción</option>
                        <?php
                        foreach (Categoria::cases() as $cat): ?>
                            <option value="<?= $cat->name ?>">
                                <?= ucfirst(strtolower($cat->name))?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Agregar producto</button>
              </div>
            </form>
          </div>
        </div>
</body>
</html>

