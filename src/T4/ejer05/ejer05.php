<!--Crea un cierre que reciba un número y -->
<!--lo multiplique por una constante definida fuera de la función anónima. -->
<!--Comprueba el funcionamiento invocando el cierre con algún valor.-->


<?php

const CONSTANTE = 2;




$cierre = function ($n){
    echo $n * CONSTANTE;
};

$cierre(4);