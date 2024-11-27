<?php
session_start();
require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    // Récupère l'ID dans l'url
    if (isset($_GET["id"]) && !empty($_GET["id"])) {

        $id = strip_tags($_GET["id"]);

        // Récupérer les chemins des images dans la table reviews aved ID
        $sql_reviews = "SELECT image1, image2, image3 FROM reviews WHERE review_id = :review_id";
        $query_reviews = $db->prepare($sql_reviews);
        $query_reviews->execute(['review_id' => $id]);
        $review_images = $query_reviews->fetch(PDO::FETCH_ASSOC);

        // Si les images existent, on les supprime une par une
        if ($review_images) {
            foreach (['image1', 'image2', 'image3'] as $imageField) {
                $imagePath = $review_images[$imageField];
                if ($imagePath) {
                    // chemin de l'image
                    $fullImagePath = realpath('../' . $imagePath);
                    if ($fullImagePath && file_exists($fullImagePath)) {
                        // Suppression de l'image
                        unlink($fullImagePath);
                    }
                }
            }
        }

        // Suppression des informations dans la table reviews
        $sql_delete_review = "DELETE FROM reviews WHERE review_id = :review_id";
        $query_delete = $db->prepare($sql_delete_review);
        $query_delete->execute(['review_id' => $id]);

        require_once("../close.php");

        // Redirection vers addreviews.php
        header("Location: addreviews.php");
        exit();
    }
} else {
    header("Location: panel.php");
    exit;
}
?>