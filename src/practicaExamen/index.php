<?php

use Practicas\src\Sesion;

require_once  "clases/Sesion.php";
require_once  "clases/Database.php";

$sesion = Sesion::init();
if (!$sesion->active()) {
    header("Location: login.php");
    exit();
}

$usuario = $sesion->get("usuarioActivo");
var_dump($usuario);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>BlogiFy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<main class="container mt-4">
    <div class="container">
        <header class="mt-4">
            <h1>BlogiFy ⋅.˳˳.⋅ॱ˙˙ॱ⋅.˳˳.⋅ॱ˙˙ॱᐧ.˳˳.⋅</h1>
            <p>
                <?= $usuario->getNombre()." ".$usuario->getApellido() ?>, 2DAW<br />
                curso 2024|25
            </p>
        </header>

        <main>
            <form method="post">
                <div class="row">

                    <div class="m-3">
                        <a href="./main.php" class="btn btn-dark">Inicio</a>
                        <a href="./articulo.php" class="btn btn-primary">Escribir un artículo</a>
                        <a href="./index.php" class="btn btn-danger">Cerrar Sesión</a>
                    </div>
                    <div class="m-3">
                        <table class="table table-striped">
                            <thead>
                            <th>Titulo del artículo</th>
                            </thead>
                            <tbody>

                            <?php
                            $sql = "SELECT * FROM articulo;";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $articulo = $stmt->fetchAll();

                            $i = 0;

                            while($i < count($articulo)){

                                if($articulo[$i]['idAut'] === $usuario['idUsu']){
                                    $boton = "btn btn-light";
                                    $editar = "<a  class=\"btn btn-warning\">Editar</a>";
                                    $borrar = "<a href=\"./borrar.php?idArt={$articulo[$i]['idArt']}\" class=\"btn btn-warning\">Borrar</a>";
                                }else {
                                    $boton = "btn btn-dark";
                                    $editar = "";
                                    $borrar = "";
                                }

                                echo "
                                        <tr>
                                           
                                            <td>{$articulo[$i]['titulo']}</td>
                                            
                                            <td><a href=\"./masPositivo.php?idArt={$articulo[$i]['idArt']}\" class=\"{$boton}\"><i class=\"bi bi-hand-thumbs-up-fill\"></i>{$articulo[$i]['positivos']}</a></td>
                                            <td><a href=\"./masNegativo.php?idArt={$articulo[$i]['idArt']}\" class=\"{$boton}\"><i class=\"bi bi-hand-thumbs-down-fill\"></i>{$articulo[$i]['negativos']}</a></td>

                                            <td><a href=\"./leer.php?idArt={$articulo[$i]['idArt']}\" class=\"btn btn-warning\"><i class=\"bi bi-book-fill\"></i>Leer</a></td>
                                            <td>{$editar}</td>
                                            <td>{$borrar}</td>
                                        
                                        </tr>";
                                $i++;
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </form>
        </main>
    </div>

</main>
</body>
</html>
