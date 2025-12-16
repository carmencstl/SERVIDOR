<?php

use config\BaseDatos;

class Habito {

    public static int $contadorHabitos = 0;
    private int $idCamino;
    private string $nombre;
    private string $descripcion;
    private string $autor;
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


    public function insertarHabito(): void
    {
        $db = BaseDatos::conectar();
        $usuarioActual = Sesion::getInstance()->obtenerUsuario()->getIdUsuario();

        $stmt = $db->prepare("INSERT INTO camino (nombre, descripcion, autor, categoria) 
            VALUES (:nombre, :descripcion, :autor, :categoria)");
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':autor', $usuarioActual);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->execute();
    }

    public static function devolverTodosHabitos(): array
    {
        $db = BaseDatos::conectar();
        $sql = "SELECT * FROM camino";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $habito = $stmt->fetchAll(PDO::FETCH_CLASS, Habito::class);
        return $habito;
    }

    public static function devolverHabitoPorFiltro(string $valor): array
    {
        $db = BaseDatos::conectar();

        $termino = trim($valor);
        $sql = "SELECT * FROM camino WHERE LOWER(nombre) LIKE :valor
                                            OR LOWER(descripcion) LIKE :valor
                                            OR LOWER(autor) LIKE :valor
                                            OR LOWER(categoria) LIKE :valor";

        $stmt = $db->prepare($sql);
        $stmt->execute([":valor" => "%$valor%"]);

        $habitos = $stmt->fetchAll(PDO::FETCH_CLASS, Habito::class);

        return $habitos;
    }


    public static function devolverHabitoPorCategoria(string $categoria): array
    {
        $db = BaseDatos::conectar();
        $sql = "SELECT * FROM camino WHERE categoria = :categoria";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        $habito = $stmt->fetchAll(PDO::FETCH_CLASS, Habito::class);
        return $habito;
    }

    public static function buscarConFiltros(string $termino = "", string $categoria = ""): array
    {
        $resultado = [];

        if (empty($termino) && empty($categoria)) {
            $resultado = self::devolverTodosHabitos();
        } elseif (!empty($termino) && empty($categoria)) {
            $resultado = self::devolverHabitoPorFiltro($termino);
        } elseif (empty($termino) && !empty($categoria)) {
            $resultado = self::devolverHabitoPorCategoria($categoria);
        } else {
            $habitosPorTermino = self::devolverHabitoPorFiltro($termino);
            $resultado = array_filter($habitosPorTermino, function($habito) use ($categoria) {
                return $habito->getCategoria() === $categoria;
            });
        }

        return $resultado;
    }


    public static function getContadorHabitos(): int
    {
        return self::$contadorHabitos;
    }

    public static function setContadorHabitos(int $contadorHabitos): void
    {
        self::$contadorHabitos = $contadorHabitos;
    }

    public function getIdCamino(): int
    {
        return $this->idCamino;
    }

    public function setIdCamino(int $idCamino): void
    {
        $this->idCamino = $idCamino;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): void
    {
        $this->autor = $autor;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }




    public function mostrarHabito(Habito $habito): void
    {
        echo "<tr>";
        echo "<td>" . $habito->getNombre() . "</td>";
        echo "<td>" . $habito->getDescripcion() . "</td>";
        echo "<td>" . $habito->getCategoria() . "</td>";
        echo "<td>" . $habito->getAutor() . "</td>";
        echo "<td>";
        echo "<form method=\"POST\" style=\"display:inline;\">";
        echo "<input type=\"hidden\" name=\"actualizar\" value=\"" . $this->idCamino  . "\">";
        echo "<button class=\"btn btn-sm btn-primary me-1\">Actualizar</button>";
        echo "</form>";
        echo "<form method=\"POST\" style=\"display:inline;\">";
        echo "<input type=\"hidden\" name=\"eliminar\" value=\"" . $this->idCamino . "\">";
        echo "<button type=\"submit\" class=\"btn btn-sm btn-danger\">Eliminar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }


}