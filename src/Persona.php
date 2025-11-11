<?php
class Persona {
    public $nombre;
    public $edad;
    public $email;

    public function __construct($nombre, $edad, $email) {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->email = $email;
    }

    public function mostrarInfo() {
        return "Nombre: {$this->nombre}<br>Edad: {$this->edad}<br>Email: {$this->email}";
    }
}
?>