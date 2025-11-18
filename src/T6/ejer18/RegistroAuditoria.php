<?php


trait RegistroAuditoria
{
    public function registrarAccion(string $accion): void
    {
        echo "Acción registrada: {$accion} <br>";
    }
}
