<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora Multiplicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Multiplicadora</h1>
            <form action="ejer01POST.php" method="get">
                <div class="mb-3">
                    <label>Primer numero</label>
                    <input type="number" name="numero1">
                </div>
                <div class="mb-3">
                    <label>Segundo numero</label>
                    <input type="number"  name="numero2">
                </div>
                <button class="btn btn-outline-primary">Multiplicar</button>
            </form>
        </div>
</body>
</html>

<?php
