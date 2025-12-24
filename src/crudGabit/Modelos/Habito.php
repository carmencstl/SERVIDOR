<?php

namespace CrudGabit\Modelos;

use CrudGabit\Config\DataBase;
use CrudGabit\Config\Session;
use PDO;

class Habito {

    public static int $contadorHabitos = 0;
    private int $idCamino;
    private string $nombre;
    private string $descripcion;
    private int $autor;
    private string $categoria;


    public function __construct(
        $idCamino = null,
        $nombre = null,
        $descripcion = null,
        $autor = null,
        $categoria = null,
    )
    {
        if($nombre !== null) {
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->autor = $autor;
            $this->categoria = $categoria;
            self::$contadorHabitos++;
        }
    }

    /**
     * Eliminar hábito por su ID
     * @param int $idCamino
     * @return void
     */
    public static function deleteHabitById(int $idCamino): void
    {
        $db = DataBase::connect();
        $sql = "DELETE FROM camino WHERE idCamino = :idCamino";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idCamino", $idCamino, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Obtener todos los hábitos del usuario actual
     * @return array
     */
    public static function getHabitsByUser(): array
    {
        $db = DataBase::connect();
        $autor = Session::get("id");

        $sql = "SELECT c.*, u.nombreUsuario as nombreAutor 
            FROM camino c 
            INNER JOIN usuario u ON c.autor = u.idUsuario 
            WHERE c.autor = :autor";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":autor", $autor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener hábito por su ID
     * @param int $idCamino
     * @return Habito|null
     */
    public static function getById(int $idCamino): ?Habito
    {
        $db = DataBase::connect();
        $sql = "SELECT * FROM camino WHERE idCamino = :idCamino";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idCamino", $idCamino, PDO::PARAM_INT);
        $stmt->execute();
        $habito = $stmt->fetchObject(Habito::class);
        return $habito ?: null;
    }

    /**
     * Actualizar hábito en la base de datos
     * @param int $idCamino
     * @param string $nombre
     * @param string $descripcion
     * @param string $categoria
     * @return bool
     */
    public static function actualizarHabito(int $idCamino, string $nombre, string $descripcion, string $categoria): bool
    {
        $db = DataBase::connect();
        $sql = "UPDATE camino 
                SET nombre = :nombre, descripcion = :descripcion, categoria = :categoria 
                WHERE idCamino = :idCamino";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => $descripcion,
            ":categoria" => $categoria,
            ":idCamino" => $idCamino
        ]);
    }

    /**
     * Insertar hábito en la base de datos
     * @return bool
     */
    public function insertarHabitoEnBD(): bool
    {
        $db = DataBase::connect();
        $stmt = $db->prepare("INSERT INTO camino (nombre, descripcion, autor, categoria) 
            VALUES (:nombre, :descripcion, :autor, :categoria)");
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':autor' => $this->autor,
            ':categoria' => $this->categoria
        ]);
    }

    /**
     * Crear una nueva instancia de Habito
     * @param string $nombre
     * @param string $descripcion
     * @param string $categoria
     * @return Habito
     */
    public static function crearHabito(string $nombre, string $descripcion, string $categoria): Habito
    {
        $usuarioActual = Session::get("id");
        $habito = new self();
        $habito->nombre = ucfirst($nombre);
        $habito->descripcion = $descripcion;
        $habito->autor = $usuarioActual;
        $habito->categoria = $categoria;
        return $habito;
    }

    // GETTERS Y SETTERS
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getIdCamino(): int
    {
        return $this->idCamino;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setAutor(int $autor): void
    {
        $this->autor = $autor;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

}