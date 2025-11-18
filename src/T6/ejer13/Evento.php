<?php

class Evento
{

    public MesesDelAnio $mes;

    /**
     * @param MesesDelAnio $mes
     */
    public function __construct(MesesDelAnio $mes)
    {
        $this->mes = $mes;
    }
    public function esVerano(): bool
    {
        return match ($this->mes) {
            MesesDelAnio::JUNIO,
            MesesDelAnio::JULIO,
            MesesDelAnio::AGOSTO => true,
            default => false
        };
    }
}