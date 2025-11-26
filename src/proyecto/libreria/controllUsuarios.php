<?php

require_once __DIR__ . "/../clases/Usuario.php";
require_once __DIR__ . "/../conexiones/bbdd.php";


/**
 * @param Usuario $usuario
 * @return void
 */
function agregarUsuario($usuario): void
{
    $pdo = conectarBD();

    $sql = "INSERT INTO usuario (nombreUsuario, nombre, apellidos, email, password, foto, rol, fechaRegistro) 
            VALUES(:nombreUsuario, :nombre, :apellidos, :email, :password, :foto, :rol, :fechaRegistro)";

    $resultado = $pdo->prepare($sql);
    $resultado->bindValue(":nombreUsuario", $usuario->getNombreUsuario());
    $resultado->bindValue(":nombre", $usuario->getNombre());
    $resultado->bindValue(":apellidos", $usuario->getApellidos());
    $resultado->bindValue(":email", $usuario->getEmail());
    $resultado->bindValue(":password", $usuario->getPassword());
    $resultado->bindValue(":foto", $usuario->getFoto());
    $resultado->bindValue(":rol", $usuario->getRol());
    $resultado->bindValue(":fechaRegistro", $usuario->getFechaRegistro());

    if($resultado->execute()){
        $usuario->setIdUsuario($pdo->lastInsertId());
    }
}

/**
 * @param string $correo
 * @return bool
 */
function verificarUsuarioExistente(string $correo): bool
{
    $pdo = conectarBD();
    $sql = "SELECT * FROM usuario WHERE email = :correo";
    $resultado = $pdo->prepare($sql);
    $resultado->bindParam(":correo", $correo);
    $resultado->execute();
    return $resultado->rowCount() > 0;
}

/**
 * @param string $correo
 * @param string $password
 * @return bool
 */
function autenticarUsuario(string $correo, string $password): bool
{
    $pdo = conectarBD();
    $sql = "SELECT password FROM usuario WHERE email = :correo";
    $resultado = $pdo->prepare($sql);
    $resultado->bindParam(":correo", $correo);
    $resultado->execute();

    if($resultado->rowCount() > 0){
        $usuario = $resultado->fetch(PDO::FETCH_ASSOC);
        return $password === $usuario["password"];
    }
    return false;
}

/**
 * @param $correo
 * @return void
 */
function deleteUser($correo): void
{
    if(verificarUsuarioExistente($correo)) {
        $usuarios = $_SESSION["usuario"] ?? [];
        foreach ($usuarios as $index => $usuario) {
            if ($usuario->getCorreo() == $correo) {
                array_splice($usuarios, $index, 1);
            }
        }
        $_SESSION["usuario"] = $usuarios;
    }
}

/**
 * @param string $correo
 * @return Usuario|null
 */
function buscarUsuarioPorCorreo(string $correo): ?Usuario
{
    $pdo = conectarBD();
    $sql = "SELECT * FROM usuario WHERE email = :correo";
    $resultado = $pdo->prepare($sql);
    $resultado->bindParam(":correo", $correo);
    $resultado->execute();

    $usuario = $resultado->fetchObject(Usuario::class);
    return $usuario ?: null;
}

    function buscarUsuarioPorNombre(string $nombre): ?Usuario
    {
        $usuarioEncontrado = null;
        $usuarios = $_SESSION["usuario"] ?? [];
        foreach ($usuarios as $usuario) {
            if ($usuario->getNombre() === $nombre) {
                $usuarioEncontrado = $usuario;
            }
        }
        return $usuarioEncontrado;
    }

    /**
     * @param string $correoOriginal
     * @param string $nuevoNombre
     * @param string $nuevoCorreo
     * @param string $nuevoRol
     * @return void
     */
    function actualizarUsuario(string $correoOriginal,
                               string $nuevoNombre,
                               string $nuevoCorreo,
                               string $nuevoRol): void
    {
        $usuarios = $_SESSION["usuario"] ?? [];
        foreach ($usuarios as $usuario) {
            if ($usuario->getCorreo() === $correoOriginal) {
                $usuario->setNombre($nuevoNombre);
                $usuario->setCorreo($nuevoCorreo);
                $usuario->setRol($nuevoRol);
            }
        }
        $_SESSION["usuario"] = $usuarios;
    }

    /**
     * @param string $correoOriginal
     * @param string $nombre
     * @param string $correo
     * @param string $rol
     * @return void
     */
    function actualizarUsuarioExistente(string $correoOriginal, string $nombre, string $correo, string $rol): void
    {
        actualizarUsuario($correoOriginal, $nombre, $correo, $rol);
        header("Location: usuarios.php");
    }

    /**
     * @return bool
     */
    function esAdmin(): bool
    {
        $esAdmin = false;
        if (isset($_SESSION["usuarioActual"])) {
            $usuarioActual = $_SESSION["usuarioActual"];
            if ($usuarioActual->getRol() === "admin") {
                $esAdmin = true;
            }
        }
        return $esAdmin;
    }

    /**
     * @param $usuario
     * @return void
     */
    function mostrarDatos($usuario): void
    {
        echo "<tr>";
        echo "<td>" . $usuario["nombreUsuario"] . "</td>";
        echo "<td>" . $usuario["nombre"] . "</td>";
        echo "<td>" . $usuario["apellido"] . "</td>";
        echo "<td>" . $usuario["email"] . "</td>";
        echo "<td>" . $usuario["rol"] . "</td>";
        echo "<td>";
        echo "<form method=\"POST\" style=\"display:inline;\">";
        echo "<input type=\"hidden\" name=\"actualizar\" value=\"" . $usuario["email"] . "\">";
        echo "<button class=\"btn btn-sm btn-primary me-1\">Actualizar</button>";
        echo "</form>";
        echo "<form method=\"POST\" style=\"display:inline;\">";
        echo "<input type=\"hidden\" name=\"eliminar\" value=\"" . $usuario["email"] . "\">";
        echo "<button type=\"submit\" class=\"btn btn-sm btn-danger\">Eliminar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }