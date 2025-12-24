<?php

namespace CrudGabit\Modelos;

use CrudGabit\Config\DataBase;
use PDO;

class Usuario {
    private int $idUsuario;
    private string $nombreUsuario;
    private string $nombre;
    private string $apellidos;
    private ?string $email;
    private string $password;
    private string $rol;


    /**
     * Crear una nueva instancia de Usuario
     * @param string $nombreUsuario
     * @param string $nombre
     * @param string $apellidos
     * @param string|null $email
     * @param string $password
     * @param string $rol
     * @return Usuario
     */
    public static function crear(
        string $nombreUsuario,
        string $nombre,
        string $apellidos,
        ?string $email,
        string $password,
        string $rol = "usuario"
    ): Usuario {
        $usuario = new self();
        $usuario->nombreUsuario = strtolower($nombreUsuario);
        $usuario->nombre        = ucfirst($nombre);
        $usuario->apellidos     = ucwords($apellidos);
        $usuario->email         = $email;
        $usuario->password      = $password;
        $usuario->rol           = $rol;
        return $usuario;
    }


    /**
     * Insertar el usuario en la base de datos
     * @return bool
     */
    public function insertarUsuario(): bool {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("INSERT INTO usuario (nombreUsuario, nombre, apellidos, email, password, rol) 
                               VALUES (:nu, :n, :a, :e, :p, :r)");
        return $stmt->execute([
            ":nu" => $this->nombreUsuario,
            ":n"  => $this->nombre,
            ":a"  => $this->apellidos,
            ":e"  => $this->email,
            ":p" => password_hash($this->password, PASSWORD_DEFAULT),
            ":r"  => $this->rol
        ]);
    }

    /**
     * Actualizar usuario existente
     * @param int $idUsuario
     * @param string $nombreUsuario
     * @param string $nombre
     * @param string $apellidos
     * @param string|null $email
     * @param string $rol
     * @return bool
     */
    public static function actualizarUsuario(
        int $idUsuario,
        string $nombreUsuario,
        string $nombre,
        string $apellidos,
        ?string $email,
        string $rol
    ): bool {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("UPDATE usuario 
                               SET nombreUsuario = :nombreUsuario,
                                   nombre = :nombre,
                                   apellidos = :apellidos,
                                   email = :email,
                                   rol = :rol
                               WHERE idUsuario = :idUsuario");
        return $stmt->execute([
            ":nombreUsuario" => strtolower($nombreUsuario),
            ":nombre"        => ucfirst($nombre),
            ":apellidos"     => ucwords($apellidos),
            ":email"         => $email,
            ":rol"           => $rol,
            ":idUsuario"     => $idUsuario
        ]);
    }


    /**
     * Traer todos los usuarios
     * @return array
     */
    public static function getAllUsers(): array {
        $pdo = DataBase::connect();
        return $pdo->query("SELECT * FROM usuario")->fetchAll(PDO::FETCH_CLASS, self::class);
    }


    /**
     * @param int $id
     * @return Usuario|null
     */
    public static function getById(int $id): ?Usuario {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
        $stmt->execute([":id" => $id]);
        $usuario = $stmt->fetchObject(self::class);
        return $usuario ?: null;
    }


    /**
     * Eliminar usuario por su ID
     * @param int $id
     * @return bool
     */
    public static function deleteUserById(int $id): bool {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE idUsuario = :id");
        return $stmt->execute([":id" => $id]);
    }

    /**
     * Buscar usuario por email
     * @param string $email
     * @return Usuario|null
     */
    public static function getByEmail(string $email): ?Usuario {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->execute([":email" => $email]);
        $usuario = $stmt->fetchObject(self::class);
        return $usuario ?: null;
    }

    /**
     * Buscar usuario por nombreUsuario
     * @param string $nombreUsuario
     * @return Usuario|null
     */
    public static function getByNombreUsuario(string $nombreUsuario): ?Usuario {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombreUsuario = :nombreUsuario");
        $stmt->execute([":nombreUsuario" => strtolower($nombreUsuario)]);
        $usuario = $stmt->fetchObject(self::class);
        return $usuario ?: null;
    }

    /**
     * Buscar usuario por email y password
     * @param string $email
     * @param string $password
     * @return Usuario|null
     */
    public static function getByEmailAndPassword(string $email, string $password): ?Usuario {
        $pdo = DataBase::connect();
        $resultado = null;

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->execute([":email" => $email]);
        $usuario = $stmt->fetchObject(self::class);

        if ($usuario && password_verify($password, $usuario->password)) {
            $resultado = $usuario;
        }

        return $resultado;
    }

    /**
     * Comprobar el rol de un usuario por su ID
     * @param int $idUsuario
     * @return string
     */
    public static function comprobarRol(int $idUsuario): string {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT rol FROM usuario WHERE idUsuario = :id");
        $stmt->execute([":id" => $idUsuario]);
        $rol = $stmt->fetchColumn();
        return $rol ?: "usuario";
    }



    // Getters
    public function getId(): int { return $this->idUsuario; }
    public function getNombreUsuario(): string { return $this->nombreUsuario; }
    public function getNombre(): string { return $this->nombre; }
    public function getApellidos(): string { return $this->apellidos; }
    public function getEmail(): ?string { return $this->email; }
    public function getRol(): string { return $this->rol; }

    // Setters
    public function setNombreUsuario(string $nombreUsuario): void
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }


}