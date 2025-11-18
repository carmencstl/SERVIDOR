<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Conversor a pesetas</title>
</head>
<body>

<div class="container mt-4">
    <form action="ejer02POST.php" method="post">
        <div class="row">
            <div class="col-2">
                <label class="form-label">Cantidad de euros a convertir:</label>
            </div>
            <div class="col-2">
                <input class="form-control" name="euros" type="number" step="any">
            </div>
        </div>
        <button class="btn btn-outline-dark">Convertir</button>
    </form>
</div>

</body>
</html>


<?php
