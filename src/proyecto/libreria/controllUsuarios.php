<?php

/**
 * @param Usuario $usuario
 * @return void
 */
 function agregarUsuario(Usuario $usuario): void
 {

    if(verificarUsuarioExistente($usuario->getCorreo())) {
        echo "El usuario ya existe";
    }
    else{
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
        }
    }
