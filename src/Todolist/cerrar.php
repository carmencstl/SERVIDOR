<?php

    require_once "autoload.php";

    session_start();
    $_SESSION=[];
    session_destroy();

    Clases\Request::redirect("index.php");