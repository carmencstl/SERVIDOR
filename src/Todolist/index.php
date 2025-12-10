<?php

  /**
	 * Desarrollo web en Entorno Servidor
	 * Todo List
	 * Antonio J. Sánchez 
	 */

  require_once "autoload.php" ;
  require_once "./libreria/database.php";
  require_once "./clases/Usuario.php";
  session_start();

use Clases\Usuario;

if (isset($_SESSION["usuarioConectado"])):
		Request::redirect("index.php");
	endif;

  if (!empty($_POST)):
      try {
          # conectamos con la base de datos utilizando PDO
	      $pdo=createConnection();

//		  echo "Base datos abierta";

          # recuperamos los datos del formulario
          $email    = $_POST["email"] ?? null ;
          $password = $_POST["password"] ?? null ;

          if (($email !== null) and ($password !== null)):
              # escribimos una PLANTILLA con la sentencia SQL
              $sql = "SELECT * FROM usuarios WHERE email = :email AND password = :pass ; " ;
//		        $result=$pdo->query("SHOW TABLES;");
//		        var_dump($result->fetchAll());

              # preparamos la sentencia SQL a partir de la plantilla
              $stmt = $pdo->prepare($sql) ;

              # 3. vinculando los parámetros y lanzando la consulta
              $stmt->bindParam(":email", $email, PDO::PARAM_STR) ;
              $stmt->bindParam(":pass", $password, PDO::PARAM_STR, 8) ;
              $stmt->execute() ;

			  //deveulve falso si no logea
              $user = $stmt->fetchObject(Usuario::class);

              if(is_object($user)):
	              $_SESSION["usuarioConectado"]=$user;
		        $_SESSION["timepo"]=time();
                  # redirigimos
              \Practicas\src\Request::redirect("main.php");
              else: $mensaje = "El email o la contraseña son incorrectos." ;
			  endif;
          else:
              $mensaje = "El email y la contraseña son obligatorios." ;
          endif ;

      } catch(PDOException $pdoe) {
          die("**ERROR: " . $pdoe->getMessage()) ;
      }
  endif ;

  # mostramos mensaje de conexión
  #echo "Se ha conectado correctamente<br/>" ;

  # El método query lanza una consulta contra la BD y devuelve un
  # objeto de tipo PDOStatement: implementa una interfaz Traversable
  # que convierte el objeto en un iterable
  # $resultado = $pdo->query("SELECT * FROM usuario ;") ;

  # RECUPERANDO INFORMACIÓN
  # 1. PDOStatement es iterable
  # 2. A través del método fetchAll() de la clase PDOStatement
  #$datos = $resultado->fetchAll(PDO::FETCH_CLASS, Usuario::class) ;
  #$fila = $resultado->fetch(PDO::FETCH_OBJ) ;
  #while ($fila = $resultado->fetchObject(Usuario::class)):
  #    echo $fila ;
  #endwhile ;



?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Bases de Datos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
</head>
<body>
  <div class="container mt-4">

      <form method="post">
          <input class="form-control" type="email" name="email"
                value="david@email.com"
                placeholder="email@email.com" autofocus required /><br/>

          <input class="form-control" type="password" name="password"
                placeholder="Introduce tu contraseña" required /><br/>

          <?php if(isset($mensaje)): ?>
              <div class="alert alert-danger"><?= $mensaje ?></div>
          <?php endif ; ?>


          <button class="btn btn-primary">Entrar</button>
      </form>


  </div>
</body>
</html>
