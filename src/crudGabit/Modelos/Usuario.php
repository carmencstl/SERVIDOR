<?php

namespace CrudGabit\Modelos;

use CrudGabit\Config\DataBase;
use PDO;

class Usuario {
    // Propiedades que coinciden con las columnas de tu BD para el mapeo automático
    private int $idUsuario;
    private string $nombreUsuario;
    private string $nombre;
    private string $apellidos;
    private ?string $email;
    private string $password;
    private string $rol;
    private ?string $fechaRegistro;
    // Constructor corregido
    public function __construct(
        string $nombreUsuario = "",
        string $nombre = "",
        string $apellidos = "",
        string $email = "",
        string $password = "password",
        string $rol = "usuario",
    ) {
        // Solo asignamos si recibimos datos (evita errores al usar fetchObject)
        if (!empty($nombreUsuario)) {
            $this->nombreUsuario = strtolower($nombreUsuario);
            $this->nombre = ucfirst($nombre);
            $this->apellidos = ucwords($apellidos);
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
        }
    }

    // Getters necesarios para la sesión y el Auth
    public function getId(): int {
        return $this->idUsuario;
    }

    public function getNombreUsuario(): string { return $this->nombreUsuario; }
    public function getNombre(): string { return $this->nombre; }
    public function getApellidos(): string { return $this->apellidos; }
    public function getEmail(): ?string { return $this->email; }
    public function getRol(): string { return $this->rol; }

    /**
     * MÉTODO CLAVE: Busca al usuario y verifica la contraseña
     */
    public static function getByEmailAndPassword(string $email, string $password): Usuario|false
    {
        try {
            $pdo = DataBase::connect();
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :ema LIMIT 1");
            $stmt->execute([":ema" => $email]);

            // Mapea el resultado directamente a esta clase
            $usuario = $stmt->fetchObject(self::class);

            if ($usuario) {
                // Si usas contraseñas cifradas con password_hash:
//                if (password_verify($password, $usuario->password)) {
//                    return $usuario;
//                }
                // SI TUS CONTRASEÑAS EN LA BD SON TEXTO PLANO (ej: "1234"), usa esto:
                 if ($password === $usuario->password) return $usuario;
            }

            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function getById(int $id): ?Usuario
    {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
        $stmt->execute([":id" => $id]);

        $usuario = $stmt->fetchObject(self::class);
        return $usuario ?: null;
    }

    public static function buscarPorEmail(string $email): ?Usuario
    {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->execute([":email" => $email]);

        $usuario = $stmt->fetchObject(self::class);
        return $usuario ?: null;
    }

    public static function comprobarRol(int $id): ?string
    {
        $pdo = DataBase::connect();
        $stmt = $pdo->prepare("SELECT rol FROM usuario WHERE id = :id");
        $stmt->execute([":id" => $id]);

        return $stmt->fetchColumn() ?: null;
    }

    public function insertarUsuario(): bool
    {
        $pdo = DataBase::connect();
        $sql = "INSERT INTO usuario (nombreUsuario, nombre, apellidos, email, password, rol) 
                VALUES (:nu, :n, :a, :e, :p, :r)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":nu" => $this->nombreUsuario,
            ":n"  => $this->nombre,
            ":a"  => $this->apellidos,
            ":e"  => $this->email,
            ":p"  => $this->password,
            ":r"  => $this->rol
        ]);
    }
}