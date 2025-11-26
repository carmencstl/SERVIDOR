<?php

class Usuario{

    public static int $contadorUsuarios = 0;
    private int $idUsuario;
    private string $nombreUsuario;
    private string $nombre;
    private string $apellidos;
    private ?string $email;
    private string $password;
    private string $rol;
    private ?string $fechaRegistro;
    private ?string $foto;
    private bool $activo;

    public function __construct(
        $nombreUsuario = null,
        $nombre = null,
        $apellidos = null,
        $email = null,
        $password = null,
        $rol = "usuario",
        $foto = null
    ) {
        if($nombreUsuario !== null) {
            $this->nombreUsuario = $nombreUsuario;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->email = $email;
            $this->password = $password;
            $this->foto = $foto;
            $this->rol = $rol;
            $this->fechaRegistro = date("Y-m-d");
            $this->activo = false;
            self::$contadorUsuarios++;
        }
    }


    public static function getContadorUsuarios(): int
    {
        return self::$contadorUsuarios;
    }

    public static function setContadorUsuarios(int $contadorUsuarios): void
    {
        self::$contadorUsuarios = $contadorUsuarios;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getNombreUsuario(): string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(string $nombreUsuario): void
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public function getFechaRegistro(): ?string
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(string $fechaRegistro): void
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): void
    {
        $this->activo = $activo;
    }





}