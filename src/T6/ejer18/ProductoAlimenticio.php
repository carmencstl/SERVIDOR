<?php

class ProductoAlimenticio extends Producto  implements Importable {

    use RegistroAuditoria;

    /**
     * @return float|int
     */
    public function calcularImpuesto(): float | int
    {
        return $this->precio * 0.05;
    }

    /**
     * @return void
     */
    public function mostrarDetalles(): void
    {
        echo "Detalles del producto: <br>";
        echo "Nombre: {$this->nombre} <br>";
        echo "Precio: {$this->precio} <br>";
        echo "Categoria: {$this->getCategoria()}";
    }
}