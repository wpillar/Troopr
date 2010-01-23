<?php
include("init.php");
$url = URL;
session_start();
    if($_SESSION['loggedin'] != 1){
        session_destroy();
        header("Location: ".URL."login.php?redirect=".$url);
    }
?>
