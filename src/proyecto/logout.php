<?php
session_start();
unset($_SESSION["usuarioActual"]);
header("Location: login.php");
exit();
?>