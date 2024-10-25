<?php

session_start();
require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {

        $id = strip_tags($_GET["id"]);

        // Faire une requête pour selectionner le chemin de la photo de l'id en question
        $sql = "SELECT plateforme_icon FROM plateformes WHERE plateforme_id=:plateforme_id";
        $query = $db->prepare($sql);
        // ["plateforme_id" => $id] c'est comme la bindvalue
        $query->execute(['plateforme_id' => $id]);

        $plateforme_icon = $query->fetch(PDO::FETCH_ASSOC);

        // Si il y a une image alors on créé la variable imagePath pour récupérer l'image
        if ($plateforme_icon) {
            $imagePath = $plateforme_icon["plateforme_icon"];
        } else {
            echo "Image non trouvée";
        }

        // Si l'image existe on la supprime avec le unlink
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $sql_delete = "DELETE FROM plateformes WHERE plateforme_id=:plateforme_id";
        $query = $db->prepare($sql_delete);

        $query->bindValue(":plateforme_id", $id);

        $query->execute(['plateforme_id' => $id]);

        $plateforme = $query->fetch();

        require_once("../close.php");
        header("Location: plateformes.php");
    }
} else {
    header("Location: panel.php");
}
