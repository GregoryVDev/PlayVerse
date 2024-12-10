<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        $id = strip_tags($_GET["id"]);

        $sql_delete = "DELETE FROM message WHERE message_id=:message_id";
        $query = $db->prepare($sql_delete);
        $query->bindValue(":message_id", $id);
        $query->execute();

        header("Location: messagerie.php");
        exit();
    }
}
