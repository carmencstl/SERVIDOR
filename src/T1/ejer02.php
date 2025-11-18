<?php
(float)$IVA= 0.21;
(integer)$precio = 100;
(float)$precio += $IVA * $precio;

echo $precio;