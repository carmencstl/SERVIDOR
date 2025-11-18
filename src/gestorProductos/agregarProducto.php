<?php

require_once "libreria/libreria.php";
session_start();

$_SESSION["productos"] = $_SESSION["productos"] ?? [];
$nombre = $_POST["nombre"] ?? "";
$precio = $_POST["precio"] ?? "";
$stock = $_POST["cantidad"] ?? "";
$categoria = $_POST["categoria"] ?? "";

$mensaje = "";
$formularioEnviado = false;

if (isset($_POST["nombre"])) {
    $formularioEnviado = true;


    if (comprobarPrecio($precio)) {
        $producto = [
                "nombre" => $nombre,
                "precio" => $precio,
                "stock" => $stock,
                "categoria" => $categoria
        ];
        array_push($_SESSION["productos"], $producto);
        $mensaje = "✅ Producto agregado correctamente.";
    } else {
        $mensaje = "⚠️ El precio no es correcto.";
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Agregar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h5 class="card-title mb-3">Agregar un nuevo producto</h5>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                   placeholder="Nombre del producto" autofocus required>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" step="0.01" class="form-control" id="cantidad" name="cantidad"
                                   placeholder="Unidades" required>
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio unitario</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio"
                                   placeholder="€" required>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select id="categoria" name="categoria" class="form-select" required>
                                <option value="">-- Selecciona --</option>
                                <option value="Higiene">Higiene</option>
                                <option value="Lácteos">Lácteos</option>
                                <option value="Aceites">Aceites</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php if ($formularioEnviado && !empty($mensaje)): ?>
                <div class="alert mt-3 <?= str_contains($mensaje, '✅') ? 'alert-success' : 'alert-danger' ?>">
                    <?= ($mensaje) ?>
                </div>
            <?php endif; ?>
            <div class="mt-3">
                <a href="index.php">Volver al inicio</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>
