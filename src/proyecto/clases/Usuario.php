<?php

class Usuario{

    public static int $contadorUsuarios = 0;
//    private int $id;
    private string $nombreUsuario;
    private string $nombre;
    private string $apellido;
    private ?string $correo;
    private string $contrasena;
    private string $rol;

    private bool $activo;

    public function __construct($nombreUsuario, $nombre, $apellido, $correo, $contrasena)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->rol = "usuario";
        $this->activo = false;
        self::$contadorUsuarios++;
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

    /**
     * @return string
     */
    public function getNombreUsuario(): string
    {
        return $this->nombreUsuario;
    }

    /**
     * @return string
     */
    public function getApellido(): string
    {
        return $this->apellido;
    }

    /**
     * @return bool
     */
    public function isActivo(): bool
    {
        return $this->activo;
    }




    /**
     * @param string $nombre
     * @return void
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @param string|null $correo
     * @return void
     */
    public function setCorreo(?string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @param string $contrasena
     * @return void
     */
    public function setContrasena(string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    /**
     * @param string $rol
     * @return void
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @param string $nombreUsuario
     * @return void
     */
    public function setNombreUsuario(string $nombreUsuario): void
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /**
     * @return string
     */
    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function setActivo(bool $activo): void
    {
        $this->activo = $activo;
    }




}