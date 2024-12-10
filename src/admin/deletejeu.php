<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {

        $game_id = strip_tags($_GET["id"]);

        try {

            // Faire une requête pour selectionner le chemin de la photo de l'id en question
            $sql = "SELECT jacket, background, image1, image2, image3, image4 FROM games WHERE game_id=:game_id";
            $query = $db->prepare($sql);

            $query->bindValue(":game_id", $game_id);
            $query->execute();

            $game = $query->fetch(PDO::FETCH_ASSOC);

            // Si il y a une image alors on créé la variable imagePath pour récupérer l'image
            if ($game) { // Si le jeu existe, on peut procéder à la suppression
                $db->beginTransaction(); // Démarrer une transaction pour assurer la cohérence des suppressions

                // Supprimer les plateformes associées au jeu dans la table de liaison
                $sql_delete_platforms = "DELETE FROM gamesplateformes WHERE game_id = :game_id";
                $query_delete_platforms = $db->prepare($sql_delete_platforms);
                $query_delete_platforms->bindValue(":game_id", $game_id);
                $query_delete_platforms->execute();

                // Supprimer les fichiers image du serveur si les chemins sont valides
                foreach ($game as $imagePath) {
                    if (!empty($imagePath) && file_exists($imagePath)) {
                        unlink($imagePath); // Suppression du fichier si il n'est pas vide et si il existe
                    }
                }

                // Supprimer le jeu de la table "games"

                $sql_delete_game = "DELETE FROM games WHERE game_id = :game_id";
                $query_delete_game = $db->prepare($sql_delete_game);

                $query_delete_game->bindValue("game_id", $game_id);
                $query_delete_game->execute();

                $db->commit(); // Confirmer les suppressions

                // Message de confirmation et rédirection
                echo "<script>
            alert('Le jeu et ses images ont été supprimés avec succès.');
            window.location.href = 'jeux.php'; </script>";
            } else {
                // Message d'erreur si le jeu n'existe pas
                echo "<script> alert('Erreur : Jeu non trouvé.');
            window.location.href = 'jeux.php'; </script>";
            }
        } catch (Exception $e) {
            $db->rollBack(); // Annuler toutes les opérations en cas d'erreur
            echo "<script>alert(" . json_encode('Erreur SQL : ' . $e->getMessage()) . ");</script>";
        }
    } else {
        // Redirection avec message d'erreur si l'ID est manquant ou vide
        echo "<script> alert('Erreur : ID de jeu non spécifié ou invalide.');
        window.location.href = 'jeux.php'; </script>";
    }
}
