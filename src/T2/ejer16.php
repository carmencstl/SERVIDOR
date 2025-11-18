<?php include "informacion.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Videoclub</title>
</head>
<body>

<div class="container">
    <h1>VideoClub</h1>

    <?php foreach ($series as $serie): ?>
        <div class="row mb-2">
            <div class="col">
                <div class="row">
                    <div class="col-2">
                        <img class="w-100 shadow rounded" src="<?= $serie["poster"] ?>">
                    </div>

                    <div class="col">
                        <h3><?= $serie["titulo"] ?></h3>
                        <h6><?= $serie["plataforma"] . ", " . $serie["nota"] ?></h6>
                        <p class="text-justify"><?= $serie["argumento"] ?></p>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>