<?php

    try{
        #CONEXIÓN A LA BASE DE DATOS
        $dsn = "mysql:host=db;dbname=servidorDAW;charset=utf8";
        $pdo = PDO::connect($dsn, "root", "root" ); #De clase PDO\MySQL
    } catch (PDOException $pdoe) {
        die("ERROR {$pdoe->getMessage()}");
    }
   $resultado = $pdo->query("SELECT * FROM usuario ;");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba BBDD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Lista de usuarios</h1>
        <ul class="list-group">
            <?php foreach ($resultado as $fila): ?>
                <li class="list-group-item">
                    <?php echo ($fila["nombre"] . ' ' . $fila["apellido"]); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

