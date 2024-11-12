<?php

session_start();

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
    exit();
}

require_once("../connect.php");

// Vérification que l'ID est bien passé dans l'URL et non vide
if (!isset($_GET["id"]) && empty($_GET["id"])) {
    header("Location: messagerie.php");
    exit();
}

// Nettoie l'ID et s'assure qu'il est un entier
$id = (int) strip_tags($_GET["id"]);

// Requête pour récupérer le message correspondant
$sql = "SELECT * FROM message WHERE message_id = :message_id";
$query = $db->prepare($sql);
$query->bindValue(":message_id", $id, PDO::PARAM_INT);
$query->execute();
$messages = $query->fetch(PDO::FETCH_ASSOC);

// Vérification de l'existence du message et du statut "lu"
if ($messages) {
    if ($messages['lu'] === "unread") {
        // Mise à jour du statut en "lu" si le message est non lu
        $sql_update = "UPDATE message SET lu = 'read' WHERE message_id = :message_id";
        $update_query = $db->prepare($sql_update);
        $update_query->bindValue(":message_id", $id, PDO::PARAM_INT);
        $update_query->execute();
    }
} else {
    // Alerte si l'ID est invalide ou si le message n'existe pas
    echo "<script>alert('ID invalide ou message introuvable.'); window.location.href = 'messagerie.php';</script>";
    exit();
}

require_once("../close.php");
