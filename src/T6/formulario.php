<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Persona</title>
</head>
<body>
    <h2>Formulario de Persona</h2>
    <form action="receptor.php" method="post">
        Nombre: <input type="text" name="nombre" required><br><br>
        Edad: <input type="number" name="edad" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
