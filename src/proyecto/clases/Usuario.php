<?php

use config\BaseDatos;

class Usuario{

    public static int $contadorUsuarios = 0;
    private int $idUsuario;
    private string $nombreUsuario{
        set{
            $this->nombreUsuario = strtolower($value);
        }
    }
    private string $nombre {
        set{
            $this->nombre = ucfirst($value);
        }
    }
    private string $apellidos{
        set{
            $this->apellidos = ucwords($value);
        }
    }
    private ?string $email;
    private string $password;
    private string $rol;
    private ?string $fechaRegistro{
        set{
            $this->fechaRegistro = date("d-m-Y", strtotime($value));
        }
    }
    private ?string $foto;

    public function __construct(
        $nombreUsuario = null,
        $nombre = null,
        $apellidos = null,
        $email = null,
        $password = "password",
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

    /**
     * Inserta un nuevo usuario en la base de datos.
     * @return void
     */
    public function insertarUsuario(): void
    {
        $db = BaseDatos::conectar();

        $sql = "INSERT INTO usuario (nombreUsuario, nombre, apellidos, email, password, rol, fechaRegistro) 
            VALUES (:nombreUsuario, :nombre, :apellidos, :email, :password, :rol, NOW())";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":nombreUsuario" => $this->nombreUsuario,
            ":nombre" => $this->nombre,
            ":apellidos" => $this->apellidos,
            ":email" => $this->email,
            ":password" => $this->password,
            ":rol" => $this->rol
        ]);
    }

    /**
     * Busca un usuario por su email en la base de datos.
     * @param string $email
     * @return Usuario|null El usuario encontrado o null si no existe.
     */
    public static function buscarPorEmail(string $email): ?Usuario
    {
        $db = BaseDatos::conectar();

        $sql = "SELECT * FROM usuario WHERE email = :email";

        $stmt = $db->prepare($sql);
        $stmt->execute([":email" => $email]);

        $usuario = $stmt->fetchObject(Usuario::class);

        return $usuario ?: null;
    }


    /**
     * Actualiza un usuario existente en la base de datos
     * @param string $email
     * @return void
     */
    public function actualizarUsuario(): void
    {
        $db = BaseDatos::conectar();

        $sql = "UPDATE usuario SET nombreUsuario = :nombreUsuario, nombre = :nombre, 
            apellidos = :apellidos, email = :email, password = :password, rol = :rol
            WHERE idUsuario = :idUsuario";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":nombreUsuario" => $this->nombreUsuario,
            ":nombre" => $this->nombre,
            ":apellidos" => $this->apellidos,
            ":email" => $this->email,
            ":password" => $this->password,
            ":rol" => $this->rol,
            ":idUsuario" => $this->idUsuario
        ]);
    }

        /**
     * Elimina un usuario de la base de datos por su email.
     * @param string $email
     * @return void
     */
    public static function eliminarUsuario(string $email): void
    {
        $db = BaseDatos::conectar();

        $sql = "DELETE FROM usuario WHERE email = :email";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":email" => $email
        ]);
    }
    /**
     * Devuelve todos los usuarios de la base de datos.
     * @return array Un array de objetos User.
     */
    public static function devolverUsuarios(): array
    {
        $db = BaseDatos::conectar();

        $sql = "SELECT * FROM usuario";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);

        return $usuarios;
    }


    /**
     * Devuelve los usuarios que coinciden con un filtro específico.
     * @param string $valor El valor a buscar en el campo especificado.
     * @return array Un array de objetos User que coinciden con el filtro.
     */
    public static function devolverUsuarioPorFiltro(string $valor): array
    {
        $db = BaseDatos::conectar();

        $termino = trim($valor);
        $sql = "SELECT * FROM usuario WHERE LOWER(nombreUsuario) LIKE :valor
                                            OR LOWER(nombre) LIKE :valor
                                            OR LOWER(apellidos) LIKE :valor
                                            OR LOWER(email) LIKE :valor";

        $stmt = $db->prepare($sql);
        $stmt->execute([":valor" => "%$valor%"]);

        $usuarios = $stmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);

        return $usuarios;
    }


    public static function comprobarCredenciales(string $correo, string $password): ?Usuario
    {
        $db = BaseDatos::conectar();
        $sql = "SELECT * FROM usuario WHERE email = :email AND password = :password";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":email" => $correo,
            ":password" => $password
        ]);

        $usuario = $stmt->fetchObject(Usuario::class);

        return $usuario ?: null;
    }

    public function mostrarDatos(Usuario $usuario): void
    {
        echo "<tr>";
        echo "<td>" . $usuario->getNombreUsuario() . "</td>";
        echo "<td>" . $usuario->getNombre() . "</td>";
        echo "<td>" . $usuario->getApellidos() . "</td>";
        echo "<td>" . $usuario->getEmail() . "</td>";
        echo "<td>" . $usuario->getRol() . "</td>";
        echo "<td>";
        echo "<form method=\"POST\" style=\"display:inline;\">";
        echo "<input type=\"hidden\" name=\"actualizar\" value=\"" . $usuario->getEmail(). "\">";
        echo "<button type=\"submit\" class=\"btn btn-sm btn-primary me-1\">Actualizar</button>";
        echo "</form>";
        echo "<form method=\"POST\" style=\"display:inline;\">";
        echo "<input type=\"hidden\" name=\"eliminar\" value=\"" . $usuario->getEmail() . "\">";
        echo "<button type=\"submit\" class=\"btn btn-sm btn-danger\">Eliminar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }



    }