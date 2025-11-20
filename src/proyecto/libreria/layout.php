<?php
    function mostrarNav(string $nombreUser): void
    {
        echo  " 
     <nav class=\"navbar navbar-dark\">
            <div class=\"container-fluid\">
                <a href=\"../dashboard.php\" class=\"navbar-brand\"> Gabit Dashboard</a>
                <div class=\"d-flex align-items-center gap-3\">
                    <span class=\"navbar-text\">$nombreUser</span>
                    <a href=\"../login.php\" class=\"btn btn-outline-light btn-sm\">Cerrar Sesión</a>
                </div>
            </div>
     </nav> ";
    }