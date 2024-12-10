<?php
session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Vérification que les champs du formulaire sont remplis
        if (
            isset($_POST["review_title"], $_POST["paragraph1"], $_POST["paragraph2"], $_POST["paragraph3"], $_POST["high_point"], $_POST["weak_point"]) &&
            !empty(trim($_POST["review_title"])) &&
            !empty(trim($_POST["paragraph1"])) &&
            !empty(trim($_POST["paragraph2"])) &&
            !empty(trim($_POST["paragraph3"])) &&
            !empty(trim($_POST["high_point"])) &&
            !empty(trim($_POST["weak_point"])) &&
            isset($_FILES["image1"], $_FILES["image2"], $_FILES["image3"]) &&
            is_uploaded_file($_FILES["image1"]["tmp_name"]) &&
            is_uploaded_file($_FILES["image2"]["tmp_name"]) &&
            is_uploaded_file($_FILES["image3"]["tmp_name"])
        ) {
            // Récupération de l'ID de l'admin connecté
            $admin_id = $_SESSION["admin_gamer"]["admin_id"];

            $review_title = strip_tags($_POST["review_title"]);
            $paragraph1 = strip_tags($_POST["paragraph1"]);
            $paragraph2 = strip_tags($_POST["paragraph2"]);
            $paragraph3 = strip_tags($_POST["paragraph3"]);
            $high_point = strip_tags($_POST["high_point"]);
            $weak_point = strip_tags($_POST["weak_point"]);

            // Récupérer les images depuis $_FILES
            $image1 = $_FILES["image1"];
            $image2 = $_FILES["image2"];
            $image3 = $_FILES["image3"];

            // Dossier d'images
            $uploadDir = '../img/reviews/';

            // Génération de noms de fichiers uniques
            $imageName1 = md5(uniqid() . 'image1') . '.' . pathinfo($image1['name'], PATHINFO_EXTENSION);
            $imageName2 = md5(uniqid() . 'image2') . '.' . pathinfo($image2['name'], PATHINFO_EXTENSION);
            $imageName3 = md5(uniqid() . 'image3') . '.' . pathinfo($image3['name'], PATHINFO_EXTENSION);

            // Chemins complets pour déplacer les fichiers
            $imagePath1 = $uploadDir . $imageName1;
            $imagePath2 = $uploadDir . $imageName2;
            $imagePath3 = $uploadDir . $imageName3;

            // Déplacement des fichiers téléchargés
            if (
                move_uploaded_file($image1['tmp_name'], $imagePath1) &&
                move_uploaded_file($image2['tmp_name'], $imagePath2) &&
                move_uploaded_file($image3['tmp_name'], $imagePath3)
            ) {
                // Préparation de la requête SQL
                $sql_addreview = "INSERT INTO reviews (admin_id, review_title, paragraph1, paragraph2, paragraph3, image1, image2, image3, high_point, weak_point)
                                VALUES (:admin_id, :review_title, :paragraph1, :paragraph2, :paragraph3, :image1, :image2, :image3, :high_point, :weak_point)";

                $query = $db->prepare($sql_addreview);

                // Liaison des valeurs, en ajoutant le chemin relatif dans les noms des images
                $query->bindValue(":admin_id", $admin_id, PDO::PARAM_INT);
                $query->bindValue(":review_title", $review_title);
                $query->bindValue(":paragraph1", $paragraph1);
                $query->bindValue(":paragraph2", $paragraph2);
                $query->bindValue(":paragraph3", $paragraph3);
                $query->bindValue(":image1", 'img/reviews/' . $imageName1);
                $query->bindValue(":image2", 'img/reviews/' . $imageName2);
                $query->bindValue(":image3", 'img/reviews/' . $imageName3);
                $query->bindValue(":high_point", $high_point);
                $query->bindValue(":weak_point", $weak_point);

                try {
                    // Exécution de la requête
                    $query->execute();
                    $_SESSION['succes_add_review'] = "Review ajoutée avec succès !";

                    // Redirection
                    header("Location: ../admin/addreviews.php");
                    exit();

                } catch (PDOException $e) {
                    echo "Erreur SQL : " . $e->getMessage();
                }
            } else {
                echo "Erreur lors du téléchargement des fichiers.";
            }
        } else {
            echo "Certains champs sont manquants ou mal remplis.";
        }
    }
} else {
    header("Location: ../index.php");
}

$sql = "SELECT * FROM reviews ORDER BY review_id DESC";
$query = $db->prepare($sql);

$query->execute();

$reviews = $query->fetchAll(PDO::FETCH_ASSOC);

?>




<?php include "./template/navbar.php"; ?>
<main>

<?php
    if (isset($_SESSION['succes_add_review'])) {
        echo '<p class="success-message">' . $_SESSION['succes_add_review'] . '</p>';
        // Supprimer le message après l'affichage
        unset($_SESSION['succes_add_review']);
    }
    if (isset($_SESSION['succes_edit_review'])) {
        echo '<p class="success-message">' . $_SESSION['succes_edit_review'] . '</p>';
        // Supprimer le message après l'affichage
        unset($_SESSION['succes_edit_review']);
    }
    if (isset($_SESSION['succes_delete_review'])) {
        echo '<p class="success-message">' . $_SESSION['succes_delete_review'] . '</p>';
        // Supprimer le message après l'affichage
        unset($_SESSION['succes_delete_review']);
    }
?>

    <section class="page">
        <h1>Gestions des reviews </h1>
    </section>

    <section class="formulaire">
        <form class="formulaire" method="POST" enctype="multipart/form-data">
            <h4>Ajouter une review</h4>

            <div class="container-title">
                <label for="review_title">Titre de la review :</label>
                <input type="text" placeholder="Titre de la review" name="review_title" id="review_title" required
                    style="margin-bottom: 20px;">
            </div>

            <div class="addreviews-container">

                <div class="addreviews-container-paragraph">
                    <div class="container-description review-para">
                        <label for="paragraph1">Paragraphe 1 :</label>
                        <textarea class="review-para" placeholder="Contenu du paragraphe 1" name="paragraph1"
                            id="paragraph1" required style="margin-bottom: 20px;"></textarea>
                    </div>
                    <div class="container-description review-para">
                        <label for="paragraph2">Paragraphe 2 :</label>
                        <textarea class="review-para" placeholder="Contenu du paragraphe 2" name="paragraph2"
                            id="paragraph2" required style="margin-bottom: 20px;"></textarea>
                    </div>
                    <div class="container-description">
                        <label for="paragraph3">Paragraphe 3 :</label>
                        <textarea class="review-para" placeholder="Contenu du paragraphe 3" name="paragraph3"
                            id="paragraph3" required style="margin-bottom: 20px;"></textarea>
                    </div>
                </div>

                <div class="addreviews-container-img">
                    <div class="container-image addreview-img">
                        <label class="uploadlabel" for="image1">Uploader image 1</label>
                        <input type="file" id="image1" name="image1" class="image" required
                            onchange="previewImage(this, 'image1Preview')">
                        <div class="preview" id="image1Preview"></div>
                    </div>

                    <div class="container-image addreview-img">
                        <label class="uploadlabel" for="image2">Uploader image 2</label>
                        <input type="file" id="image2" name="image2" class="image" required
                            onchange="previewImage(this, 'image2Preview')">
                        <div class="preview" id="image2Preview"></div>
                    </div>

                    <div class="container-image addreview-img">
                        <label class="uploadlabel" for="image3">Uploader image 3</label>
                        <input type="file" id="image3" name="image3" class="image" required
                            onchange="previewImage(this, 'image3Preview')">
                        <div class="preview" id="image3Preview"></div>
                    </div>

                </div>

                <div class="addreviews-container-points">
                    <div class="container-title">
                        <label for="high_point">Points forts :</label>
                        <textarea class="review-para" placeholder="Points forts de la review" name="high_point"
                            id="high_point" required style="margin-bottom: 20px;"></textarea>
                    </div>
                    <div class="container-title">
                        <label for="weak_point">Points faibles :</label>
                        <textarea class="review-para" placeholder="Points faibles de la review" name="weak_point"
                            id="weak_point" required style="margin-bottom: 20px;"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="send">Envoyer</button>
        </form>
    </section>

    <section class="dashboard">
        <h2>Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Titre</th>
                </tr>
            </thead>
            <?php foreach ($reviews as $review) { ?>
            <tbody>
                <tr data-page="1">
                    <td class="actions">
                        <a class="btn-edit" href="editreview.php?id=<?= $review["review_id"] ?>">Modifier</a>
                        <a class="btn-delete" href="deletereview.php?id=<?= $review["review_id"] ?>">Supprimer</a>
                    </td>
                    <td><?= $review["review_title"] ?></td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </section>
</main>
<script src="./js/previewgame.js"></script>
<script src="./js/admin.js"></script>
</body>

</html>