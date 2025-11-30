<?php

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

    public function mostrarHabito(): void
    {
        echo "<tr>";
        echo "<td>" . $this->nombre . "</td>";
        echo "<td>" . $this->descripcion . "</td>";
        echo "<td>" . $this->autor . "</td>";
        echo "<td>" . $this->categoria . "</td>";
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