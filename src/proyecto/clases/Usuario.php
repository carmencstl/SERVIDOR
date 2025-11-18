<?php

class Usuario{

//    private int $id;
    private string $nombre;
    private ?string $correo;
    private string $contrasena;
    private string $rol;

    public function __construct($nombre, $correo, $contrasena)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->rol = "user";
    }

    /**
     * @return string|null
     */
    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    /**
     * @return string
     */
    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getRol(): string
    {
        return $this->rol;
    }



}