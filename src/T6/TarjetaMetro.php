<?php
class TarjetaMetro
{


    /**
     * @param string $codigo
     * @param string $tipo
     * @param int $viajes
     * @param float $saldo
     * @param bool $activo
     */
    public function __construct( private readonly string $codigo,
                                 private readonly string $tipo,
                                 private  int $viajes,
                                 public private(set) float $saldo = 0.0,
                                 public bool  $activo = true )
    {}


    /**
     * Recarga la tarjeta con la cantidad indicada
     * Solo funciona si la tarjeta está activa
     *
     * @param float $cantidad Cantidad a recargar
     * @return float|false Saldo actualizado o false si la tarjeta no está activa
     */
    public function recargar(float $cantidad): float|false
    {
        if (!$this->activo) {
            return false;
        }

        $this->saldo += $cantidad;
        return $this->saldo;
    }

    /**
     * Realiza un viaje con la tarjeta
     * Verifica saldo suficiente y que la tarjeta esté activa
     *
     * @param float $precio Precio del billete
     * @return float|false Saldo actualizado tras el viaje o false si no se puede realizar
     */
    public function viajar(float $precio): float|false
    {
        // Verificar si la tarjeta está activa
        if (!$this->activo) {
            return false;
        }

        // Verificar si hay saldo suficiente
        if ($this->saldo < $precio) {
            return false;
        }

        // Realizar el viaje
        $this->saldo -= $precio;
        $this->viajes++;

        return $this->saldo;
    }

    /**
     * Obtiene información completa de la tarjeta mediante getters
     * Como un to string
     *
     * @return array Datos de la tarjeta
     */
    public function obtenerDatos(): array
    {
        return [
            'codigo' => $this->codigo,
            'saldo' => $this->saldo,
            'tipo' => $this->tipo,
            'viajes' => $this->viajes,
            'activo' => $this->activo
        ];
    }
}

