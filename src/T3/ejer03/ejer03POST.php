<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambio de divisas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php

        const FACTORES = [166.386, 1.05, 0.87, 157.25];

        $divisa = (int)$_POST["divisas"];
        $euros = $_POST["euros"];
        echo $divisa;
    
    ?>
</div>

</body>
</html>



<?php
