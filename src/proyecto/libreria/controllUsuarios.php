<?php

/**
 * @param Usuario $usuario
 * @return void
 */
 function agregarUsuario(Usuario $usuario): void
 {

    if(!verificarUsuarioExistente($usuario->getCorreo())) {
        array_push($_SESSION["usuario"], $usuario);
    }
}

/**
 * @param string $correo
 * @return bool
 */
function verificarUsuarioExistente(string $correo): bool
{
    $exists = false;
    $i = 0;
    $usuarios = $_SESSION["usuario"] ?? [];
    while (!$exists && $i < count($usuarios)) {
            if($usuarios[$i]->getCorreo() == $correo) {
                $exists = true;
            }
        $i++;
    }
    return $exists;
}

/**
 * @param string $correo
 * @param string $contrasena
 * @return bool
 */
function autenticarUsuario(string $correo, string $contrasena): bool
{
    $autenticado = false;
    $i = 0;
    $usuarios = $_SESSION["usuario"] ?? [];
    while (!$autenticado && $i < count($usuarios)) {
        if($usuarios[$i]->getCorreo() == $correo && $usuarios[$i]->getContrasena() == $contrasena) {
            $autenticado = true;
        }
        $i++;
    }
    return $autenticado;

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
        $usuarioEncontrado = null;
        $usuarios = $_SESSION["usuario"] ?? [];
        foreach ($usuarios as $usuario) {
            if ($usuario->getCorreo() === $correo) {
                $usuarioEncontrado = $usuario;
            }
        }
        return $usuarioEncontrado;
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
     * @param string $nombreUsuario
     * @param string $nombre
     * @param string $apellido
     * @param string $correo
     * @param string $password
     * @return void
     */
    function crearNuevoUsuario(string $nombreUsuario, string $nombre, string $apellido, string $correo, string $password = "default123"): void
    {
        $nuevoUsuario = new Usuario($nombreUsuario, $nombre, $apellido, $correo, $password);
        agregarUsuario($nuevoUsuario);
        header("Location: usuarios.php");
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