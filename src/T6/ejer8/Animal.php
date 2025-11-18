<?php

class Animal
{

    private readonly string $especie; /* A los readonly  no se le puede dar un valor por defecto*/

    public readonly string $habitat;

    public ?Animal $companero;

    /**
     * @var int
     */
    public private(set) int $edad {
        get {
            $edad = $this->edad;
            if ($this->habitat === "selva" || $this->habitat === "sabana") {
                $edad += 2;
            }
            return $edad;
        }
    }

    /**
     * @var float|int
     */
    public private(set) float|int $peso {
        set {
            if ($value < 0) {
                $this->peso = 0;
            } elseif (isset($this->peso) && $value > ($this->peso * 1.5)) {
                $this->peso = $this->peso * 1.5;
            } else {
                $this->peso = $value;
            }
        }
    }

    /**
     * @var bool
     */
    public bool $vivo {
        set {
            $this->vivo = ($this->edad >= 20) ? false : $value;
        }
    }


    /**
     * @param string $especie
     * @param string $habitat
     */
    public function __construct(string $especie, string $habitat)
    {
        $this->especie = $especie;
        $this->habitat = $habitat;
        $this->edad = 0;
        $this->peso = 0;
        $this->vivo = true;
        $this->companero = null;
    }

    /**
     * @param int $anios
     * @return void
     */
    public function crecer(int $anios): void
    {
        $this->edad += $anios;
    }

    /**
     * @param float $kgs
     * @return void
     */
    public function alimentar(float $kgs): void
    {
        if ($this->vivo) {
            $this->peso += $kgs;
        }
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return "Especie: {$this->especie} <br>
            Edad: {$this->edad} <br>
            Peso: {$this->peso} <br>
            Habitat: {$this->habitat} <br>
            Vivo: " . ($this->vivo ? "Sí" : "No") . " <br>
            Companero: " . ($this->companero?->especie ?? "Ninguno");
    }

    /**
     * @param float $peso
     * @return void
     */
    public function setPeso(float $peso): void
    {
        $this->peso = $peso;
    }


    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->$name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function __unset(string $name): void
    {
        unset($this->$name);
    }

    /**
     * @return void
     */
    public function __clone(): void
    {
        if(!is_null($this->companero)) {
            $this->companero = clone $this->companero;
        }

    }

}

$leon = new Animal("Leon", "sabana");
$leon->crecer(2);
echo $leon;

