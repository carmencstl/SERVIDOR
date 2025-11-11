<?php
$temperatura = 19;

if($temperatura > 20):
    echo "Calor";
elseif($temperatura >= 10 && $temperatura <= 20):
    echo "Templado";
elseif($temperatura < 10):
    echo "Frio";
endif;