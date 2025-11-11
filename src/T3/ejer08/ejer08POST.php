<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php

        if(!empty($_POST["numeros"])):
            $num = explode(",", rtrim($_POST["numeros"], ","));
            $suma = 0;

            foreach ($num as $item) {
                if(is_numeric($item)) $suma += $item;
            }
            echo "La media es: " . $suma/count($num);
        else:
            echo "Por favor introduce numeros para calcular";
        endif;


    ?>
</div>

</body>
</html>


