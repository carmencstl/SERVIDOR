<?php

class Animal{

    private readonly string $especie;
    public private(set) int $edad {
        get{
             $edad = $this->edad;
            if($this->habitat === "selva" || $this->habitat === "sabana"){
                $edad += 2;
            }
            return $edad;
        }
    }

    public private(set) float $peso{
        set{
            if($value < 0){
                $this->peso = 0;
            }
            elseif ($value > ($this->peso * 1.5)){
                    $this->peso += ($this->peso * 1.5);
            }

        }

    }

    public bool $vivo{

        set{
            if($this->edad >= 20){
                $this->vivo = false;
            }
        }
    }

    public readonly string $habitat;

    public ?Animal $companero;

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

    public function crecer(int $anios): void
    {
        $this->edad += $anios;
    }

    public function alimentar(float $kgs): void
    {
        if($this->vivo){
            $this->peso += $kgs;
        }
    }

    public function __toString(): string
    {
        return "Especie: {$this->especie} <br>
                Edad: {$this->edad} <br>
                Peso: {$this->peso} <br>
                Habitat: {$this->habitat} <br>
                Vivo: {$this->vivo} <br>
                Companero: {$this->companero->especie}
        ";
    }

    public function setPeso(float $peso): void
    {
        $this->peso = $peso;
    }

//    public function __invoke($sonido)
//    {
//        switch ($sonido){
//
//        }
//    }

//    public function __isset(string $name): bool
//    {
//        // TODO: Implement __isset() method.
//    }

//        public function __unset(string $name): void
//        {
//            // TODO: Implement __unset() method.
//        }

//    public function __clone(): void
//    {
//        // TODO: Implement __clone() method.
//    }


}

