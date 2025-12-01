<?php

  /**
	 * Desarrollo web en Entorno Servidor
	 * Todo List
	 * Antonio J. Sánchez 
	 */

  require_once "autoload.php" ;
  require_once "./libreria/database.php" ;
  use \clases\Usuario;
  use \clases\Request;
  use \clases\Sesion;
  use \clases\BaseDatos;
  session_start();

  if (!isset($_SESSION["usuarioConectado"])):
	Request::redirect("index.php");
  endif;

  if (time()-$_SESSION["tiempo"]>3600*2):
	Sesion::cerrarSesion("cerrar.php");
  endif;

  $_SESSION["tiempo"]=time(); //para que se refresque el tiempo si el usuario esta trabajando

	$db=\Clases\BaseDatos::conectar();
	$db->consulta();

//      $sql = "SELECT * FROM Tarea WHERE idUsuario=$usuarioConectado->idUsuario;" ;
//	  $resultados=$pdo->query($sql);


?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
</head>
<body>
  <div class="container">
	  <table>
		  <thead>
			  <th>
				  <tr>Descripcion</tr>
				  <tr>Fecha</tr>
				  <tr>Estado</tr>
			  </th>
		  </thead>
		  <tbody>

		  </tbody>
	  </table>


  </div>
</body>
</html>
