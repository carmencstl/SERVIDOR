<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<h2>Formulario de Persona</h2>
<?php
if (!empty($_POST)):
require_once "Persona.php";
$persona = new Persona($_POST["nombre"], $_POST["edad"], $_POST["email"]);

?>
<form action="receptor.php" method="post">
    <input type="hidden" name="serie" value="<?= urlencode(serialize($persona)) ?>">
    <?php else: ?>
    <form method="post">
        <label class="form-label">Nombre:</label>
        <input type="text" name="nombre" required><br><br>
        <label class="form-label">Edad:</label>
        <input type="number" name="edad" required><br><br>
        <label class="form-label">Email:</label>
        <input type="email" name="email" required><br><br>
        <?php
            endif;
        ?>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

