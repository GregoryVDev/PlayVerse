<?php
session_start();
require_once("../connect.php");

// Récupération des catégories
$sql_category = "SELECT * FROM category";
$query_category = $db->prepare($sql_category);
$query_category->execute();
$categories = $query_category->fetchAll(PDO::FETCH_ASSOC);

// Récupération des options PEGI
$sql_pegi = "SELECT * FROM pegi";
$query_pegi = $db->prepare($sql_pegi);
$query_pegi->execute();
$pegis = $query_pegi->fetchAll(PDO::FETCH_ASSOC);

// Récupération des plateformes
$sql_plateformes = "SELECT * FROM plateformes";
$query_plateformes = $db->prepare($sql_plateformes);
$query_plateformes->execute();
$plateformes = $query_plateformes->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour gérer l'upload sécurisé des fichiers avec formats spécifiques
function uploadFile($fileKey, $uploadDir = 'img/games/')
{
    // Liste des types MIME autorisés pour les formats PNG, JPG/JPEG et WEBP
    $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];

    // Vérifie que le fichier a été uploadé sans erreur
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE); // Vérifie le type MIME
        $mimeType = $fileInfo->file($_FILES[$fileKey]['tmp_name']); // Récupère le type MIME

        // Vérification du type MIME
        if (in_array($mimeType, $allowedTypes)) { // Accepte uniquement PNG, JPG/JPEG et WEBP
            $fileName = uniqid() . '_' . basename($_FILES[$fileKey]['name']); // Génère un nom unique
            $filePath = $uploadDir . $fileName; // Chemin du fichier

            // Déplace le fichier
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                return $filePath; // Retourne le chemin du fichier
            }
        } else {
            echo "<script>alert('Erreur : Format de fichier non autorisé. Seuls les formats PNG, JPG, et WEBP sont acceptés.');</script>";
        }
    }
    return null; // Retourne null si échec ou type incorrect
}

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupération et validation des données du formulaire
        $game_title = strip_tags($_POST["game_title"]);
        $category_id = (int) strip_tags($_POST["category_id"]);
        $pegi_id = (int) strip_tags($_POST["pegi_id"]);
        $trailer = strip_tags($_POST["trailer"]);
        $content = strip_tags($_POST["content"]);

        // Upload des fichiers
        $jacket = uploadFile('jacket');
        $background = uploadFile('background');
        $image1 = uploadFile('image1');
        $image2 = uploadFile('image2');
        $image3 = uploadFile('image3');
        $image4 = uploadFile('image4');

        // Récupération des plateformes sélectionnées
        $plateformeIds = isset($_POST['plateformeIds']) ? array_map('intval', $_POST['plateformeIds']) : [];

        try {
            // Démarrage de la transaction
            $db->beginTransaction();

            // Insertion des données dans la table `games`
            $sql_addjeu = "INSERT INTO games (game_title, admin_id, pegi_id, category_id, jacket, content, background, trailer, image1, image2, image3, image4) 
                           VALUES (:game_title, :admin_id, :pegi_id, :category_id, :jacket, :content, :background, :trailer, :image1, :image2, :image3, :image4)";
            $query = $db->prepare($sql_addjeu);

            $query->bindValue(":game_title", $game_title);
            $query->bindValue(":admin_id", $_SESSION["admin_gamer"]["admin_id"]);
            $query->bindValue(":pegi_id", $pegi_id);
            $query->bindValue(":category_id", $category_id);
            $query->bindValue(":jacket", $jacket);
            $query->bindValue(":content", $content);
            $query->bindValue(":background", $background);
            $query->bindValue(":trailer", $trailer);
            $query->bindValue(":image1", $image1);
            $query->bindValue(":image2", $image2);
            $query->bindValue(":image3", $image3);
            $query->bindValue(":image4", $image4);

            $query->execute();

            // Récupération de l'ID du jeu nouvellement inséré
            $game_id = $db->lastInsertId();

            // Insertion dans la table de liaison `gamesplateformes`
            $sql_plateforme = "INSERT INTO gamesplateformes (game_id, plateforme_id) VALUES (:game_id, :plateforme_id)";
            $query = $db->prepare($sql_plateforme);

            foreach ($plateformeIds as $plateforme_id) {
                $query->bindValue(":game_id", $game_id);
                $query->bindValue(":plateforme_id", $plateforme_id);
                $query->execute();
            }

            // Validation de la transaction
            $db->commit();
            echo "<script>alert('Les données ont été insérées avec succès.');</script>";
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'erreur
            $db->rollBack();
            echo "<script>alert('Erreur : Les données n'ont pas été insérées.');</script>";
        }
    }
}
?>


<? include "./template/navbar.php"; ?>
<main>
    <section class="page">
        <h1>Gestions des jeux</h1>
    </section>
    <section class="formulaire-games">
        <article class="img-article">
            <img src="./img/sonic.gif" alt="Sonic">
        </article>
        <article class="form-jeux">
            <form action="" method="POST" id="formajout" enctype="multipart/form-data">
                <h4>Ajouter un jeu</h4>
                <div class="container-global">
                    <div class="container-left">
                        <div class="container-titre">
                            <label for="titre">Titre :</label>
                            <input type="text" placeholder="Titre du jeu" name="game_title" id="title" required>
                        </div>

                        <div class="container-plateformes">
                            <!-- Bouton du dropdown -->
                            <button class="dropdown-btn" onclick="toggleDropdown()" type="button">--Choisir la plateforme--</button>
                            <!-- Contenu du dropdown avec checkboxes -->
                            <div class="list-plateformes">
                                <?php foreach ($plateformes as $plateforme) { ?>
                                    <label><input type="checkbox" name=plateformeIds[] value="<?= $plateforme["plateforme_id"] ?>"><?= $plateforme["plateforme_name"] ?></label>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="container-categories">
                            <label for="categorie">Catégorie :</label>
                            <select id="categorie" name="category_id" required>
                                <option value="">--Choisir la catégorie--</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?= $category["category_id"] ?>"><?= $category["category_name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="container-pegis">
                            <label for="pegis">Pegi :</label>
                            <select id="pegis" name="pegi_id" required>
                                <option value="">--Choisir le pegi--</option>
                                <?php foreach ($pegis as $pegi) { ?>
                                    <option value="<?= $pegi["pegi_id"] ?>"><?= $pegi["pegi_name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="container-trailer">
                            <label for="trailer">Trailer :</label>
                            <input type="text" placeholder="Lien du trailer" name="trailer" id="trailer" required>
                        </div>
                        <div class="container-description">
                            <label for="content">Description :</label>
                            <textarea name="content" id="content" placeholder="Description du jeu" required></textarea>
                        </div>
                        <div class="container-background">
                            <label class="uploadlabel" for="background" id="uploadLabel">Uploader le background</label>
                            <input type="file" id="background" name="background" class="image" required>
                        </div>
                    </div>
                    <div class="container-right">
                        <div class="container-image">
                            <label class="uploadlabel" for="jacket" id="uploadJacket">Uploader la jaquette</label>
                            <input type="file" id="jacket" name="jacket" class="image" required>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image1"
                                class="uploadImage">Uploader image 1</label>
                            <input type="file" id="image1" name="image1" class="image" required>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image2" class="uploadImage">Uploader image 2</label>
                            <input type="file" id="image2" name="image2" class="image" required>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image3" class="uploadImage">Uploader image 3</label>
                            <input type="file" id="image3" name="image3" class="image" required>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image4" class="uploadImage">Uploader image 4</label>
                            <input type="file" id="image4" name="image4" class="image" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="send">Envoyer</button>
            </form>
        </article>
    </section>
    <section class="dashboard">
        <h2>Dashboard</h2>

        <div class="container-search">
            <img src="../img/logos/search.svg" alt="Search">
            <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Titre</th>
                    <th>Admin</th>
                    <th><input type="checkbox"></th>
                </tr>
            </thead>
            <tbody>
                <tr data-page="1">
                    <td class="actions">
                        <a href="#" class="btn-edit">Modifier</a>
                        <a href="#" class="btn-delete">Supprimer</a>
                    </td>
                    <td>Nom</td>
                    <td>Oé le rat</td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
            </tbody>
        </table>
        <button class="deleteall">Supprimer tout</button>
    </section>
</main>
</body>
<script src="./js/admin.js"></script>

</html>

<!-- TO DO LiST 
 
- Ajouter une size pour les images de 1730 x 414 pour le background
- Le tableau à compléter en bas avec la bdd
- faire la messagerie
- faire la politique de conf
- mention légal

-->