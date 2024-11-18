<?php


session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
    exit();
}
require_once("../connect.php");


if (isset($_GET["id"])) {

    $game_id = strip_tags($_GET["id"]);

    $sql = "SELECT * FROM games WHERE game_id=:game_id";
    $query = $db->prepare($sql);

    $query->bindValue(":game_id", $game_id);
    $query->execute();

    $edit = $query->fetch();

    if (!$edit) {
        header("Location: jeux.php");
    }

    // Récupération dans games plateforme
    $sql_gplateformes = "SELECT * FROM gamesplateformes WHERE game_id=:game_id";
    $query_gplateformes = $db->prepare($sql_gplateformes);
    $query_gplateformes->bindValue(":game_id", $game_id);
    $query_gplateformes->execute();
    $gplateformes = $query_gplateformes->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: panel.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: jeux.php");
    exit();
}
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


// Vérifier si le formulaire a été soumis en utilisant une requête POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage des champs de texte pour éviter les injections et caractères non désirés
    $game_title = strip_tags($_POST["game_title"]);
    $category_id = (int) strip_tags($_POST["category_id"]);
    $pegi_id = (int) strip_tags($_POST["pegi_id"]);
    $trailer = strip_tags($_POST["trailer"]);
    $content = strip_tags($_POST["content"]);

    // Paramètres de gestion d'upload d'image : répertoire de destination, types MIME autorisés, taille maximale

    // Définir le répertoire de destination où les images seront sauvegardées après upload
    $uploadDir = 'img/games/';

    // Liste des types MIME autorisés pour les images, pour garantir l'upload de formats corrects
    // Seuls les formats JPG, JPEG, PNG et WEBP seront acceptés
    $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];

    // Définir la taille maximale du fichier à 4 Mo (4 * 1024 * 1024 octets) pour limiter l'espace occupé par chaque image
    $maxFileSize = 4 * 1024 * 1024; // 4 Mo

    // Définir les champs d'images du formulaire pour traiter chaque image individuellement
    // Chaque champ représente un type d'image qui pourrait être uploadé
    $imageFields = ['jacket', 'background', 'image1', 'image2', 'image3', 'image4'];

    // Parcourir chaque champ d'image pour vérifier et gérer l'upload
    foreach ($imageFields as $fileKey) {

        // Vérifier qu'une image est uploadée sans erreur
        // $_FILES[$fileKey] vérifie l'existence du fichier pour chaque champ, et 'error' == 0 indique qu'il n'y a pas d'erreur d'upload
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {

            // Vérifier que la taille du fichier est inférieure ou égale à la limite spécifiée
            // La fonction mime_content_type vérifie le type MIME du fichier pour assurer qu'il correspond aux formats autorisés
            if ($_FILES[$fileKey]['size'] <= $maxFileSize && in_array(mime_content_type($_FILES[$fileKey]['tmp_name']), $allowedTypes)) {

                // Générer un nom de fichier unique pour éviter les conflits de noms, avec l'extension d'origine
                // uniqid() génère un identifiant unique basé sur l'heure en microsecondes
                // pathinfo() extrait l'extension du fichier d'origine pour la conserver dans le nouveau nom
                $newFilePath = $uploadDir . uniqid() . '.' . pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);

                // Supprimer l'ancienne image du serveur si elle existe pour libérer de l'espace
                // Vérifie d'abord si le chemin est défini et que le fichier existe, puis supprime l'ancien fichier
                if (!empty($edit[$fileKey]) && file_exists($edit[$fileKey])) {
                    unlink($edit[$fileKey]); // Supprime l'ancienne image
                }

                // Déplacer le fichier depuis son emplacement temporaire vers le dossier final
                // move_uploaded_file() transfère le fichier uploadé vers le chemin défini dans $newFilePath
                move_uploaded_file($_FILES[$fileKey]['tmp_name'], $newFilePath);

                // Sauvegarder le chemin de l'image nouvellement uploadée dans une variable dynamique
                // Utilise $$fileKey pour créer une variable dynamique avec le nom de champ, afin de mettre à jour le chemin dans la base de données
                $$fileKey = $newFilePath;
            } else {
                // Afficher un message d'erreur en JavaScript si le fichier est trop volumineux ou a un type incorrect
                echo "<script>alert('Erreur : Fichier $fileKey invalide ou trop volumineux.');</script>";
            }
        } else {
            // Si aucun nouveau fichier n'est uploadé, conserver l'image existante en la récupérant dans la base de données
            $$fileKey = $edit[$fileKey];
        }
    }


    // Récupérer les plateformes sélectionnées dans le formulaire
    $plateformeIds = [];
    if (isset($_POST['plateformeIds'])) {
        $plateformeIds = array_map('intval', $_POST['plateformeIds']);
    }
    // On met un try pour les erreurs imprévues. Si un code échoue (ex : si une requête rencontre un problème) le catch permet d'attraper l'erreur et d'annuler toute la transaction pour éviter qu'une requête marche et pas l'autre, ça peut laisser la bdd dans un etat pas logique
    try {
        // Démarrer une transaction pour assurer une cohérence des données
        $db->beginTransaction();

        // Requête de mise à jour des informations du jeu avec les images et textes nettoyés
        $sql_update_game = "UPDATE games SET game_title = :game_title, category_id = :category_id, pegi_id = :pegi_id, 
                        trailer = :trailer, content = :content, jacket = :jacket, background = :background, 
                        image1 = :image1, image2 = :image2, image3 = :image3, image4 = :image4 
                        WHERE game_id = :game_id";
        $query = $db->prepare($sql_update_game);

        // Associer les valeurs aux marqueurs pour sécuriser la requête
        $query->bindValue(":game_title", $game_title);
        $query->bindValue(":category_id", $category_id);
        $query->bindValue(":pegi_id", $pegi_id);
        $query->bindValue(":trailer", $trailer);
        $query->bindValue(":content", $content);
        $query->bindValue(":jacket", $jacket);
        $query->bindValue(":background", $background);
        $query->bindValue(":image1", $image1);
        $query->bindValue(":image2", $image2);
        $query->bindValue(":image3", $image3);
        $query->bindValue(":image4", $image4);
        $query->bindValue(":game_id", $game_id);
        $query->execute();

        // Mise à jour des plateformes : supprimer les anciennes associations avant d'ajouter les nouvelles
        $db->prepare("DELETE FROM gamesplateformes WHERE game_id = :game_id")
            ->execute([':game_id' => $game_id]);

        // Ajout des nouvelles plateformes associées au jeu dans la table de liaison
        $sql_add_plateforme = "INSERT INTO gamesplateformes (game_id, plateforme_id) VALUES (:game_id, :plateforme_id)";
        $query = $db->prepare($sql_add_plateforme);

        // Parcourir chaque plateforme sélectionnée et insérer en base
        foreach ($plateformeIds as $plateforme_id) {
            $query->execute([':game_id' => $game_id, ':plateforme_id' => $plateforme_id]);
        }

        // Valider les modifications dans la base de données
        $db->commit();

        // Alerte de succès et redirection vers la page admin
        echo "<script>
            alert('Les données ont été mises à jour avec succès.');
            window.location.href = 'jeux.php';
          </script>";
    } catch (Exception $e) {
        // Annuler les modifications si une erreur survient
        $db->rollBack();
        // Afficher est alerte avec l'erreur SQL pour diagnostic et json_encode c'est une fonction qui permet d'encoder le message d'erreur. Evitation des erreurs JS comme par exemple les guillemets ou les caractère sspéciaux dans le message d'erreur pour éviter de casser la syntaxe
        echo "<script>alert(" . json_encode('Erreur SQL : ' . $e->getMessage()) . ");</script>";
    }
}


?>

<?php include "./template/navbar.php"; ?>

<main>
    <section class="page">
        <h1>Modification des jeux</h1>
    </section>
    <section class="formulaire-games">
        <article class="form-jeux">
            <form action="" method="POST" id="formajout" enctype="multipart/form-data">
                <h4>Modifier un jeu</h4>
                <div class="container-global">
                    <div class="container-left">
                        <div class="container-titre">
                            <label for="titre">Titre :</label>
                            <input type="text" placeholder="Titre du jeu" name="game_title" id="title"
                                value="<?= $edit["game_title"] ?>" required>
                        </div>

                        <div class="container-plateformes">
                            <!-- Bouton du dropdown -->
                            <button class="dropdown-btn" onclick="toggleDropdown()" type="button">--Choisir la
                                plateforme--</button>
                            <!-- Contenu du dropdown avec checkboxes -->
                            <div class="list-plateformes">
                                <?php
                                // Parcourir chaque plateforme disponible pour afficher une case à cocher
                                foreach ($plateformes as $plateforme) {
                                    // Initialiser la variable checked à une chaîne vide pour chaque plateforme
                                    $checked = "";

                                    // Vérifier si cette plateforme est déjà associée au jeu en parcourant les plateformes sélectionnées
                                    foreach ($gplateformes as $gplateforme) {
                                        if ($plateforme["plateforme_id"] === $gplateforme["plateforme_id"]) {
                                            // Si la plateforme est déjà associée au jeu, définir checked pour afficher la case cochée
                                            $checked = "checked";
                                            break; // Quitter la boucle dès qu'une correspondance est trouvée
                                        }
                                    }
                                ?>
                                    <label>
                                        <!-- Afficher une case à cocher pour la plateforme, avec la valeur et le statut checked si associé -->
                                        <input type="checkbox" name="plateformeIds[]"
                                            value="<?= $plateforme["plateforme_id"] ?>" <?= $checked ?>>
                                        <?= $plateforme["plateforme_name"] ?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="container-categories">
                            <label for="categorie">Catégorie :</label>
                            <select id="categorie" name="category_id" required>
                                <?php
                                // Parcourir chaque catégorie pour l'afficher dans le menu déroulant
                                foreach ($categories as $category) { ?>
                                    <option value="<?= $category["category_id"] ?>" <?=
                                                                                    //  condition ? valeur_si_vrai : valeur_si_faux; 
                                                                                    $category["category_id"] === $edit["category_id"] ? "selected" : "" ?>>
                                        <!-- Afficher l'option avec l'attribut selected si elle correspond à la catégorie actuelle du jeu -->
                                        <?= $category["category_name"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="container-pegis">
                            <label for="pegis">Pegi :</label>
                            <select id="pegis" name="pegi_id" required>
                                <?php
                                // Parcourir chaque option PEGI pour l'afficher dans le menu déroulant
                                foreach ($pegis as $pegi) { ?>
                                    <option value="<?= $pegi["pegi_id"] ?>"
                                        <?= $pegi["pegi_id"] === $edit["pegi_id"] ? "selected" : "" ?>>
                                        <!-- Afficher l'option avec l'attribut selected si elle correspond au PEGI actuel du jeu -->
                                        <?= $pegi["pegi_name"] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="container-trailer">
                            <label for="trailer">Trailer :</label>
                            <input type="text" placeholder="Lien du trailer" name="trailer"
                                value="<?= $edit["trailer"] ?>" id="trailer" required>
                        </div>
                        <div class="container-description">
                            <label for="content">Description :</label>
                            <textarea name="content" id="content"
                                placeholder="Description du jeu"><?= $edit["content"] ?></textarea>
                        </div>
                        <div class="container-background">
                            <label class="uploadlabel" for="background" class="uploadImg">Uploader le background</label>
                            <img src="<?= $edit["background"] ?>" alt=""
                                style="width: 235px; height: 235px; object-fit: cover;">
                            <input type="file" id="background" name="background" class="image"
                                onchange="previewImage(this, 'backgroundPreview')">
                            <div class="preview" id="backgroundPreview"></div>
                        </div>
                    </div>
                    <div class="container-right">
                        <div class="container-image">
                            <label class="uploadlabel" for="jacket" class="uploadImg">Uploader la jaquette</label>
                            <img src="<?= $edit["jacket"] ?>" alt=""
                                style="width: 235px; height: 235px; object-fit: cover; margin-bottom: 20px;">
                            <input type="file" id="jacket" name="jacket" class="image"
                                onchange="previewImage(this, 'jacketPreview')">
                            <div class="preview" id="jacketPreview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image1" class="uploadImage">Uploader image 1</label>
                            <img src="<?= $edit["image1"] ?>" alt=""
                                style="width: 235px; height: 235px; object-fit: cover; margin-bottom: 20px;">
                            <input type="file" id="image1" name="image1" class="image"
                                onchange="previewImage(this, 'image1Preview')">
                            <div class="preview" id="image1Preview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image2" class="uploadImage">Uploader image 2</label>
                            <img src="<?= $edit["image2"] ?>" alt=""
                                style="width: 235px; height: 235px; object-fit: cover; margin-bottom: 20px;">
                            <input type="file" id="image2" name="image2" class="image"
                                onchange="previewImage(this, 'image2Preview')">
                            <div class="preview" id="image2Preview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image3" class="uploadImage">Uploader image 3</label>
                            <img src="<?= $edit["image3"] ?>" alt=""
                                style="width: 235px; height: 235px; object-fit: cover; margin-bottom: 20px;">
                            <input type="file" id="image3" name="image3" class="image"
                                onchange="previewImage(this, 'image3Preview')">
                            <div class="preview" id="image3Preview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image4" class="uploadImage">Uploader image 4</label>
                            <img src="<?= $edit["image4"] ?>" alt=""
                                style="width: 235px; height: 235px; object-fit: cover; margin-bottom: 20px;">
                            <input type="file" id="image4" name="image4" class="image"
                                onchange="previewImage(this, 'image4Preview')">
                            <div class="preview" id="image4Preview"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="send" style="margin-bottom: 25px">Envoyer</button>
            </form>

        </article>
    </section>
</main>

<script src="./js/dropdown.js"></script>
<script src="./js/previewgame.js"></script>

</html>