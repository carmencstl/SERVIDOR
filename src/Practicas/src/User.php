<?php

require_once "./DataBase.php";

class User
{
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

    public function __construct(
        $nombreUsuario = null,
        $nombre = null,
        $apellidos = null,
        $email = null,
        $password = "password",
        $rol = "usuario",
        $fechaRegistro = null,
    ) {
        if($nombreUsuario !== null) {
            $this->nombreUsuario = $nombreUsuario;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
            $this->fechaRegistro = date("Y-m-d");
            self::$contadorUsuarios++;
        }
    }

    /**
     * Inserta un nuevo usuario en la base de datos.
     * @return void
     */
    public function insertarUsuario(): void
    {
        $db = DataBase::conectar();

        $sql = "INSERT INTO user (nombreUsuario, nombre, apellidos, email, password, rol, fechaRegistro) 
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
     * @return User|null El usuario encontrado o null si no existe.
     */
    public static function buscarPorEmail(string $email): ?User
    {
        $db = DataBase::conectar();

        $sql = "SELECT * FROM user WHERE email = :email";

        $stmt = $db->prepare($sql);
        $stmt->execute([":email" => $email]);

        $usuario = $stmt->fetchObject(User::class);

        return $usuario ?: null;
    }


    /**
     * Actualiza un usuario existente en la base de datos
     * @param string $email
     * @return void
     */
    public static function actualizarUsuario(string $email): void
    {
        $usuario = self::buscarPorEmail($email);

        $db = DataBase::conectar();

        $sql = "UPDATE usuario SET nombreUsuario = :nombreUsuario, nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol
                WHERE idUsuario = :idUsuario";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":nombreUsuario" => $usuario->nombreUsuario,
            ":nombre" => $usuario->nombre,
            ":apellidos" => $usuario->apellidos,
            ":email" => $usuario->email,
            ":rol" => $usuario->rol,
            ":idUsuario" => $usuario->idUsuario
        ]);
    }

    /**
     * Elimina un usuario de la base de datos por su email.
     * @param string $email
     * @return void
     */
    public static function eliminarUsuario(string $email): void
    {
        $db = DataBase::conectar();

        $sql = "DELETE FROM user WHERE email = :email";

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
        $db = DataBase::conectar();

        $sql = "SELECT * FROM user";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_CLASS, User::class);

        return $usuarios;
    }


    /**
     * Devuelve los usuarios que coinciden con un filtro específico.
     * @param string $filtro El campo por el que filtrar (e.g., 'nombre', 'email').
     * @param string $valor El valor a buscar en el campo especificado.
     * @return array Un array de objetos User que coinciden con el filtro.
     */
    public static function devolverUsuarioPorFiltro(string $filtro, string $valor): array
    {
        $db = DataBase::conectar();

        $sql = "SELECT * FROM user WHERE $filtro LIKE :valor";

        $stmt = $db->prepare($sql);
        $stmt->execute([":valor" => "%$valor%"]);

        $usuarios = $stmt->fetchAll(PDO::FETCH_CLASS, User::class);

        return $usuarios;
    }

    function mostrarDatos(User $usuario): void
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

    public static function getContadorUsuarios(): int
    {
        return self::$contadorUsuarios;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function getNombreUsuario(): string
    {
        return $this->nombreUsuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    public function getFechaRegistro(): ?string
    {
        return $this->fechaRegistro;
    }



}