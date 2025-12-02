<?php
    require_once(__DIR__ . '/../clases/Sesion.php');

    /**
     * @param string $nombreUser
     * @return void
     */
    function mostrarNav(string $nombreUser): void
    {
        echo  " 
     <nav class=\"navbar navbar-dark\">
            <div class=\"container-fluid\">
                <a href=\"../dashboard.php\" class=\"navbar-brand\"> Gabit Dashboard</a>
                <div class=\"d-flex align-items-center gap-3\">
                    <span class=\"navbar-text\">Hola, $nombreUser</span>
                    <a href=\"../logout.php\" class=\"btn btn-outline-light btn-sm\">Cerrar sesión</a>  
                </div>
            </div>
     </nav> ";
    }