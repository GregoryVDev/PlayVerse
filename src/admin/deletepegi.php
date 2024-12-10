<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {

        $id = strip_tags($_GET["id"]);

        // Faire une requête pour selectionner le chemin de la photo de l'id en question
        $sql = "SELECT pegi_icon FROM pegi WHERE pegi_id=:pegi_id";
        $query = $db->prepare($sql);
        // ["pegi_id" => $id] c'est comme la bindvalue
        $query->execute(['pegi_id' => $id]);

        $pegi_icon = $query->fetch(PDO::FETCH_ASSOC);

        // Si il y a une image alors on créé la variable imagePath pour récupérer l'image
        if ($pegi_icon) {
            $imagePath = $pegi_icon["pegi_icon"];
        } else {
            echo "Image non trouvée";
        }

        // Si l'image existe on la supprime avec le unlink
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $sql_delete = "DELETE FROM pegi WHERE pegi_id=:pegi_id";
        $query = $db->prepare($sql_delete);

        $query->bindValue(":pegi_id", $id);

        $query->execute(['pegi_id' => $id]);

        $pegiresult = $query->fetch();

        require_once("../close.php");
        header("Location: pegis.php");
    }
} else {
    header("Location: panel.php");
}
