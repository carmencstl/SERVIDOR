<!doctype html>
<html lang="s">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="methodGetB.php" method="post">
    <br/>
    <label for="nombre">Nombre Completo</label>
    <input id="nombre" type="text" name="nombre" autofocus required/>

    <br/>

    <label for="contraseña">Contraseña</label>
    <input id="nombre" type="text" name="nombre" autofocus required/>

    <br/>

    <label for="fecha">Fecha</label>
    <input id="fecha" type="date" name="fecha"/>

    <br/>

    <label for="color">Color favorito</label>
    <input id="color" type="color" name="color"/>

    <br/>


    <label for="aficiones">Aficiones</label>
    <input id="aficiones" type="checkbox" name="aficiones[]" value="musica"/>Escuchar música
    <input type="checkbox" name="aficiones[]" value="Leer"/>Leer
    <input type="checkbox" name="aficiones[]" value="Videojuegos"/>Videojuegos

    <br/>


    <label for="boton">Dale</label>
    <input id="boton" type="submit" name="boton"/>

    <br/>

</form>
</body>
</html>