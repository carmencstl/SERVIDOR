<?php
class Persona {
    public string $nombre;
    public int $edad;
    public string $email;

    public function __construct(string $nombre, int $edad, string $email) {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->email = $email;
    }

    /**
     * @return string 
     */
    public function __toString() : string
    {
        return "Nombre: {$this->nombre}<br>Edad: {$this->edad}<br>Email: {$this->email}";
    }
}
?>
