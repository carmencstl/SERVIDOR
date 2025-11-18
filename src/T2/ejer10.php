<?php

for ($i = 2; $i <= 100; $i++) {
    $divisores = 0;

    for ($j = 1; $j <= $i; $j++) {
        if ($i % $j == 0) {
            $divisores++;
        }
    }

    if ($divisores == 2) {
        echo $i . " ";
    }
}
