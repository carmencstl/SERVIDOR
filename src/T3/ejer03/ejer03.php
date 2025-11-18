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
    <h1>Cambio de divisas</h1>

    <div class="col">
        <form method="post" action="ejer03POST.php">
            <label>Cantidad de euros</label>
            <input type="number" name="euros">
            <label>Divisa</label>
            <select name="divisas[]">
                <option value="0">Peseta</option>
                <option value="1">Dolares</option>
                <option value="2">Libra</option>
                <option value="3">Yen</option>
            </select>
            <button>Convertir</button>
        </form>

    </div>

</div>

</body>
</html>



<?php
