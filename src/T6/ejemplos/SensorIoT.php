<?php

class SensorIoT {

    private readonly string $id;
    public private(set) string $ubicacion;
    public private(set) string $tipo;
    public private(set) ?float $valor;
    private array $historial;

    /**
     * Constructor de la clase SensorIoT
     *
     * @param string $id Identificador único del sensor
     * @param string $ubicacion Ubicación del sensor
     * @param string $tipo Tipo de sensor (temperatura, humedad, etc.)
     */
    public function __construct(string $id, string $ubicacion, string $tipo, ?float $valor = null, array $historial = []) {
        $this->id = $id;
        $this->ubicacion = $ubicacion;
        $this->tipo = $tipo;
    }

    /**
     * Actualiza el valor del sensor y lo añade al historial
     * Mantiene solo los 10 valores más recientes
     *
     * @param float $nuevoValor Nuevo valor del sensor
     * @return float El nuevo valor actualizado
     */
    public function actualizarValor(float $nuevoValor): float {
        $this->valor = $nuevoValor;
        $this->historial[] = $nuevoValor;
        if (count($this->historial) > 10) {
            array_shift($this->historial);
        }
        return $this->valor;
    }

    /**
     * Calcula y devuelve la media de los valores almacenados en el historial
     *
     * @return float|null Media del historial o null si está vacío
     */
    public function mediaHistorial(): ?float {
        if (empty($this->historial)) {
            return null;
        }

        $suma = array_sum($this->historial);
        $cantidad = count($this->historial);

        return $suma / $cantidad;
    }

    /**
     * Método auxiliar para obtener el historial completo (solo para depuración)
     *
     * @return array Historial de valores
     */
    public function obtenerHistorial(): array {
        return $this->historial;
    }
}

?>