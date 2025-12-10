<?php

    require_once "autoload.php";

    session_start();
    $_SESSION=[];
    session_destroy();

    \Practicas\src\Request::redirect("index.php");