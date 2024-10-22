<?php

session_start();

if (isset($_SESSION["user_gamer"])) {
    unset($_SESSION["user_gamer"]);
    header("Location: connexion.php");
    exit();
}

if (isset($_SESSION["admin_gamer"])) {
    unset($_SESSION["admin_gamer"]);
    header("Location: ./admin/connexionadmin.php");
    exit();
}
