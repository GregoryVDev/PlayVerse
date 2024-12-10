<?php
session_start();
require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {

        // Validation et nettoyage de l'ID en utilisant strip_tags et (int) pour éviter les injections
        $id = (int)strip_tags($_GET["id"]);

        // Suppression de l'entrée dans la table commentary
        $sql_delete_commentary = "DELETE FROM commentary WHERE commentary_id = :commentary_id";
        $query_delete = $db->prepare($sql_delete_commentary);

        // Exécuter la requête de suppression
        if ($query_delete->execute(['commentary_id' => $id])) {
            // Redirection en cas de succès
            header("Location: commentary.php?status=success");
        } else {
            // Gestion des erreurs : rediriger avec un message d'erreur en cas d'échec
            header("Location: commentary.php?status=error");
        }
        exit;
    }
} else {
    // Redirection vers le panneau de connexion si l'utilisateur n'est pas connecté
    header("Location: ../index.php");
    exit;
}
?>