<!doctype html>
<html lang="s">
<head>
    <meta charset="UTF-8">
    <title>MetodoPost</title>
</head>
<body>
<form action="methodPostB.php" method="post">
    <br/>
    <label for="nombre">Nombre Completo</label>
    <input id="nombre" type="text" name="nombre" autofocus required/>

    <br/>

    <label for="clave">Contraseña</label>
    <input id="clave" type="password" name="clave" required/>

    <br/>

    <label for="fecha">Fecha</label>
    <input id="fecha" type="date" name="fecha"/>

    <br/>

    <label for="color">Color favorito</label>
    <input id="color" type="color" name="color"/>

    <br/>


    <label for="aficiones">Aficiones</label>
    <select id="aficiones" name="aficiones[]" multiple>
        <option value="Musica">Musica</option>
        <option value="Leer">Leer</option>
        <option value="Videojuegos">Videojuegos</option>
        <option value="Deporte">Deporte</option>
        <option value="Puenting">Puenting</option>
        <option value="Buceo">Buceo</option>
    </select>

    <br/>


    <label for="boton">Dale</label>
    <input id="boton" type="submit" name="boton"/>

    <br/>


</form>
</body>
</html>