<?php

for($i = 1; $i <= 100; $i++){
    if($i % 3 == 0){
        if($i < 100 - 1){
            echo "$i, ";
        }
        else{
            echo "$i";
        }

    }
}