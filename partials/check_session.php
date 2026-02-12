<?php
    if (!isset($_SESSION["user"]["username"])){
        header("Location: login.php");
        exit();
    }
?>