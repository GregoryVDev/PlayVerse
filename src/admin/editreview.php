<?php
session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    // Vérifier si l'ID de la review est passé dans l'URL avec 'id' comme paramètre
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $review_id = $_GET['id'];  // Utiliser 'id' au lieu de 'review_id'


        // Récupérer les données actuelles de la review
        $sql = "SELECT * FROM reviews WHERE review_id = :review_id";
        $query = $db->prepare($sql);
        $query->bindValue(":review_id", $review_id, PDO::PARAM_INT);
        $query->execute();
        $review = $query->fetch(PDO::FETCH_ASSOC);

        if (!$review) {
            echo "Review introuvable.";
            exit;
        }

        // Si le formulaire est soumis, mettre à jour la review
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $review_title = strip_tags($_POST["review_title"]);
            $paragraph1 = strip_tags($_POST["paragraph1"]);
            $paragraph2 = strip_tags($_POST["paragraph2"]);
            $paragraph3 = strip_tags($_POST["paragraph3"]);
            $high_point = strip_tags($_POST["high_point"]);
            $weak_point = strip_tags($_POST["weak_point"]);

            // Traitement des images téléchargées (si des images sont envoyées)
            $image1 = $_FILES["image1"];
            $image2 = $_FILES["image2"];
            $image3 = $_FILES["image3"];

            $uploadDir = '../img/reviews/';

            // Variables pour les chemins des images
            $image1Path = $review['image1'];
            $image2Path = $review['image2'];
            $image3Path = $review['image3'];

            // Si une nouvelle image 1 est téléchargée, on la traite
            if (isset($image1) && is_uploaded_file($image1['tmp_name'])) {
                // Supprimer l'ancienne image si elle existe
                if (file_exists("../" . $review['image1'])) {
                    unlink("../" . $review['image1']);
                }
                $imageName1 = md5(uniqid() . 'image1') . '.' . pathinfo($image1['name'], PATHINFO_EXTENSION);
                $imagePath1 = $uploadDir . $imageName1;
                move_uploaded_file($image1['tmp_name'], $imagePath1);
                $image1Path = 'img/reviews/' . $imageName1;
            }

            // Si une nouvelle image 2 est téléchargée, on la traite
            if (isset($image2) && is_uploaded_file($image2['tmp_name'])) {
                // Supprimer l'ancienne image si elle existe
                if (file_exists("../" . $review['image2'])) {
                    unlink("../" . $review['image2']);
                }
                $imageName2 = md5(uniqid() . 'image2') . '.' . pathinfo($image2['name'], PATHINFO_EXTENSION);
                $imagePath2 = $uploadDir . $imageName2;
                move_uploaded_file($image2['tmp_name'], $imagePath2);
                $image2Path = 'img/reviews/' . $imageName2;
            }

            // Si une nouvelle image 3 est téléchargée, on la traite
            if (isset($image3) && is_uploaded_file($image3['tmp_name'])) {
                // Supprimer l'ancienne image si elle existe
                if (file_exists("../" . $review['image3'])) {
                    unlink("../" . $review['image3']);
                }
                $imageName3 = md5(uniqid() . 'image3') . '.' . pathinfo($image3['name'], PATHINFO_EXTENSION);
                $imagePath3 = $uploadDir . $imageName3;
                move_uploaded_file($image3['tmp_name'], $imagePath3);
                $image3Path = 'img/reviews/' . $imageName3;
            }

            // Préparer la requête SQL pour mettre à jour la review
            $sql_updateReview = "UPDATE reviews SET 
                                    review_title = :review_title, 
                                    paragraph1 = :paragraph1,
                                    paragraph2 = :paragraph2,
                                    paragraph3 = :paragraph3,
                                    image1 = :image1, 
                                    image2 = :image2,
                                    image3 = :image3,
                                    high_point = :high_point,
                                    weak_point = :weak_point
                                WHERE review_id = :review_id";

            $query = $db->prepare($sql_updateReview);
            $query->bindValue(":review_title", $review_title);
            $query->bindValue(":paragraph1", $paragraph1);
            $query->bindValue(":paragraph2", $paragraph2);
            $query->bindValue(":paragraph3", $paragraph3);
            $query->bindValue(":image1", $image1Path);
            $query->bindValue(":image2", $image2Path);
            $query->bindValue(":image3", $image3Path);
            $query->bindValue(":high_point", $high_point);
            $query->bindValue(":weak_point", $weak_point);
            $query->bindValue(":review_id", $review_id, PDO::PARAM_INT);

            try {
                // Exécution de la mise à jour
                $query->execute();
                // Rediriger vers la page des reviews après la mise à jour
                header("Location: addreviews.php");
                exit();
            } catch (PDOException $e) {
                echo "Erreur SQL : " . $e->getMessage();
            }
            header("Location: ../index.php"); // Rediriger vers la page d'accueil si l'admin n'est pas connecté
            exit();
        }
    } else {
        echo "ID de la review non spécifié.";
        exit;
    }
} else {
    header("Location: ../index.php"); // Rediriger vers la page d'accueil si l'admin n'est pas connecté
    exit();
}
?>

<?php include "./template/navbar.php"; ?>
<main>

    <section class="page">
        <h1>Modification de la review</h1>
    </section>

    <section class="formulaire">
        <form class="formulaire" method="POST" enctype="multipart/form-data">
            <h4>Modifier la review</h4>

            <div class="container-title">
                <label for="review_title">Titre de la review :</label>
                <input type="text" placeholder="Titre de la review" name="review_title" id="review_title" required
                    value="<?php echo htmlspecialchars($review['review_title']); ?>" style="margin-bottom: 20px;">
            </div>

            <div class="addreviews-container">
                <div class="addreviews-container-paragraph">
                    <div class="container-title">
                        <label for="paragraph1">Paragraphe 1 :</label>
                        <textarea placeholder="Contenu du paragraphe 1" name="paragraph1" id="paragraph1" required
                            style="margin-bottom: 20px;"><?php echo htmlspecialchars($review['paragraph1']); ?></textarea>
                    </div>
                    <div class="container-title">
                        <label for="paragraph2">Paragraphe 2 :</label>
                        <textarea placeholder="Contenu du paragraphe 2" name="paragraph2" id="paragraph2" required
                            style="margin-bottom: 20px;"><?php echo htmlspecialchars($review['paragraph2']); ?></textarea>
                    </div>
                    <div class="container-title">
                        <label for="paragraph3">Paragraphe 3 :</label>
                        <textarea placeholder="Contenu du paragraphe 3" name="paragraph3" id="paragraph3" required
                            style="margin-bottom: 20px;"><?php echo htmlspecialchars($review['paragraph3']); ?></textarea>
                    </div>
                </div>

                <div class="addreviews-container-img">
                    <div class="container-title">
                        <label for="image1">Image 1 :</label>
                        <input type="file" name="image1" id="image1" style="margin-bottom: 20px;">
                        <img src="../<?php echo htmlspecialchars($review['image1']); ?>" alt="Image 1 actuelle"
                            style="max-width: 100px;">
                    </div>

                    <div class="container-title">
                        <label for="image2">Image 2 :</label>
                        <input type="file" name="image2" id="image2" style="margin-bottom: 20px;">
                        <img src="../<?php echo htmlspecialchars($review['image2']); ?>" alt="Image 2 actuelle"
                            style="max-width: 100px;">
                    </div>

                    <div class="container-title">
                        <label for="image3">Image 3 :</label>
                        <input type="file" name="image3" id="image3" style="margin-bottom: 20px;">
                        <img src="../<?php echo htmlspecialchars($review['image3']); ?>" alt="Image 3 actuelle"
                            style="max-width: 100px;">
                    </div>
                </div>

                <div class="addreviews-container-points">
                    <div class="container-title">
                        <label for="high_point">Points forts :</label>
                        <textarea placeholder="Points forts de la review" name="high_point" id="high_point" required
                            style="margin-bottom: 20px;"><?php echo htmlspecialchars($review['high_point']); ?></textarea>
                    </div>
                    <div class="container-title">
                        <label for="weak_point">Points faibles :</label>
                        <textarea placeholder="Points faibles de la review" name="weak_point" id="weak_point" required
                            style="margin-bottom: 20px;"><?php echo htmlspecialchars($review['weak_point']); ?></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="send">Mettre à jour</button>
        </form>
    </section>

</main>