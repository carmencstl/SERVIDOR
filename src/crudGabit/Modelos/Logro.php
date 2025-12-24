<?php
namespace CrudGabit\Modelos;

use CrudGabit\Config\Database;
use CrudGabit\Config\Session;
use PDO;

class Logro
{
    private int $idLogro;
    private string $nombre;
    private string $descripcion;
    private int $idCamino;
    private ?string $fechaCreacion;


    public function __construct(
        string $nombre = "",
        string $descripcion = "",
        int $idCamino = 0
    ) {
        if (!empty($nombre)) {
            $this->nombre = ucfirst($nombre);
            $this->descripcion = ucfirst($descripcion);
            $this->idCamino = $idCamino;
        }
    }

    /**
     * Obtiene todos los logros del usuario actual.
     * @return array
     */
    public static function getLogrosByUser(): array
    {
        $db = DataBase::connect();
        $autor = Session::get("id");

        $sql = "SELECT l.*, c.nombre as nombreHabito 
            FROM logro l
            INNER JOIN camino c ON l.idCamino = c.idCamino
            INNER JOIN usuario u ON c.autor = u.idUsuario
            WHERE u.idUsuario = :autor";

        $stmt = $db->prepare($sql);
        $stmt->execute([":autor" => $autor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un logro por su ID.
     * @param int $idLogro
     * @return array
     */
    public static function getById(int $idLogro): array
    {
        $db = DataBase::connect();
        $sql = "SELECT l.*, c.nombre as nombreHabito 
            FROM logro l
            INNER JOIN camino c ON l.idCamino = c.idCamino
            WHERE l.idLogro = :idLogro";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idLogro", $idLogro, PDO::PARAM_INT);
        $stmt->execute();
        $logro = $stmt->fetch(PDO::FETCH_ASSOC);
        return $logro ?: [];
    }

    /**
     * Elimina un logro por su ID.
     * @param int $idLogro
     * @return bool
     */
    public static function deleteLogroById(int $idLogro): bool
    {
        $db = DataBase::connect();
        $sql = "DELETE FROM logro WHERE idLogro = :idLogro";
        $stmt = $db->prepare($sql);
        return $stmt->execute([":idLogro" => $idLogro]);
    }

    /**
     * Actualiza un logro por su ID.
     * @param int $idLogro
     * @param string $nombre
     * @param string $descripcion
     * @return bool
     */
    public static function actualizarLogro(int $idLogro, string $nombre, string $descripcion): bool
    {
        $db = DataBase::connect();
        $sql = "UPDATE logro 
                SET nombre = :nombre, descripcion = :descripcion 
                WHERE idLogro = :idLogro";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":descripcion" => $descripcion,
            ":idLogro" => $idLogro
        ]);
    }

    /**
     * Crea una instancia de Logro.
     * @param string $nombre
     * @param string $descripcion
     * @param int $idCamino
     * @return Logro
     */
    public static function crearLogro(string $nombre, string $descripcion, int $idCamino): Logro
    {
        $logro = new self();
        $logro->nombre = ucfirst($nombre);
        $logro->descripcion = ucfirst($descripcion);
        $logro->idCamino = $idCamino;
        return $logro;
    }

    /**
     * Inserta el logro en la base de datos.
     * @return bool
     */
    public function insertarLogroEnBD(): bool
    {
        $db = DataBase::connect();
        $stmt = $db->prepare("INSERT INTO logro (nombre, descripcion, idCamino) 
            VALUES (:nombre, :descripcion, :idCamino)");
        return $stmt->execute([
            ":nombre" => $this->nombre,
            ":descripcion" => $this->descripcion,
            ":idCamino" => $this->idCamino
        ]);
    }
}