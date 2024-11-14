<?php
session_start();

require_once("../connect.php");

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
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

// Récupère le pseudo de l'admin en jointure
$sql_games = "SELECT g.game_id, g.game_title, a.pseudo 
               FROM games g 
               JOIN admins a ON g.admin_id = a.admin_id";

$query_games = $db->prepare($sql_games);
$query_games->execute();
$games = $query_games->fetchAll(PDO::FETCH_ASSOC);


// Vérifie si le formulaire a été soumis via une requête POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage des données du formulaire
    $game_title = strip_tags($_POST["game_title"]); // Nettoie le titre du jeu
    $category_id = (int) strip_tags($_POST["category_id"]); // Convertit la catégorie en entier
    $pegi_id = (int) strip_tags($_POST["pegi_id"]); // Convertit l'ID PEGI en entier
    $trailer = strip_tags($_POST["trailer"]); // Nettoie l'URL du trailer
    $content = strip_tags($_POST["content"]); // Nettoie le contenu (description)

    // Définir le répertoire de destination pour les images téléchargées.

    $uploadDir = 'img/games/';
    // Définir une liste des types MIME autorisés pour les fichiers d'image.
    // Les types MIME indiquent le format du fichier et permettent de restreindre l'upload à des types d'image spécifiques.

    $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];

    // Définir la taille maximale des fichiers autorisés pour chaque image téléchargée.
    // La taille est exprimée en octets, donc 4 * 1024 * 1024 permet de convertir 4 Mo en octets (4 194 304 octets).
    $maxFileSize = 4 * 1024 * 1024; // 4 Mo

    // Créer un tableau des champs d'images définis dans le formulaire d'upload.
    // Chaque élément du tableau correspond à un nom d'image unique ('jacket', 'background', etc.),
    // utilisé comme clé pour accéder aux fichiers téléchargés et vérifier si chaque champ d'image a été rempli.
    $imageFiles = ['jacket', 'background', 'image1', 'image2', 'image3', 'image4'];

    // Boucle à travers chaque champ d'image listé dans le tableau $imageFiles.
    // Cette boucle permet de traiter chaque image individuellement en appliquant les mêmes vérifications
    // et opérations (vérification de la taille, du type, génération d'un nom unique, etc.) pour chaque fichier.
    foreach ($imageFiles as $fileKey) {

        // Vérifier si un fichier a été uploadé pour le champ d'image actuel ($fileKey)
        // et s'il n'y a pas eu d'erreur lors de l'upload.
        // $_FILES[$fileKey]['error'] est un code indiquant l'état de l'upload :
        // - '0' signifie que l'upload s'est bien passé,
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {

            // Vérifier que le fichier répond aux critères de taille et de type MIME avant de l'accepter.
            // On compare la taille du fichier ($_FILES[$fileKey]['size']) avec la limite de taille ($maxFileSize),
            // et on vérifie le type MIME avec mime_content_type(), en s’assurant qu'il est dans $allowedTypes.

            if ($_FILES[$fileKey]['size'] <= $maxFileSize && in_array(mime_content_type($_FILES[$fileKey]['tmp_name']), $allowedTypes)) {

                // Générer un nom unique pour le fichier uploadé pour éviter les conflits de noms.
                // uniqid() génère un identifiant unique basé sur l’heure actuelle en microsecondes,
                // et pathinfo() est utilisé pour obtenir l’extension du fichier original.
                // Ce nouveau nom est ensuite combiné avec le répertoire cible ($uploadDir) pour créer un chemin complet
                // vers lequel le fichier sera déplacé.
                ${$fileKey} = $uploadDir . uniqid() . '.' . pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);

                // Déplacer le fichier depuis son emplacement temporaire (où il est stocké par PHP après l'upload)
                // vers le dossier final spécifié par $uploadDir. 
                // La fonction move_uploaded_file() renvoie 'true' si le déplacement a réussi et 'false' en cas d'échec.
                move_uploaded_file($_FILES[$fileKey]['tmp_name'], ${$fileKey});
            } else {
                // Si la taille du fichier ou son type MIME ne respectent pas les règles établies,
                // Cette alerte mentionne le nom du champ d'image en erreur pour que l'utilisateur sache quel fichier corriger.
                echo "<script>alert('Erreur : Fichier $fileKey invalide ou trop volumineux.');</script>";
            }
        }
    }

    // Insertion des données du jeu dans la base de données
    try {
        // Préparation de la requête d'insertion avec les valeurs de jeu et d'images
        $sql_addjeu = "INSERT INTO games (game_title, admin_id, pegi_id, category_id, jacket, content, background, trailer, image1, image2, image3, image4) 
                           VALUES (:game_title, :admin_id, :pegi_id, :category_id, :jacket, :content, :background, :trailer, :image1, :image2, :image3, :image4)";
        $query = $db->prepare($sql_addjeu); // Préparation de la requête

        // Association des valeurs des champs du formulaire aux paramètres de la requête
        $query->bindValue(":game_title", $game_title);
        $query->bindValue(":admin_id", $_SESSION["admin_gamer"]["admin_id"]);
        $query->bindValue(":pegi_id", $pegi_id);
        $query->bindValue(":category_id", $category_id);
        $query->bindValue(":jacket", $jacket ?? null); // Utilisation de null si l'image n'a pas été uploadée
        $query->bindValue(":content", $content);
        $query->bindValue(":background", $background ?? null);
        $query->bindValue(":trailer", $trailer);
        $query->bindValue(":image1", $image1 ?? null);
        $query->bindValue(":image2", $image2 ?? null);
        $query->bindValue(":image3", $image3 ?? null);
        $query->bindValue(":image4", $image4 ?? null);

        // Exécution de la requête d'insertion
        $query->execute();

        // Récupère l'ID du jeu nouvellement inséré pour les insertions suivantes
        $game_id = $db->lastInsertId();

        // Insertion des plateformes sélectionnées si elles sont présentes
        if (isset($_POST['plateformeIds'])) {
            $sql_add_plateforme = "INSERT INTO gamesplateformes (game_id, plateforme_id) VALUES (:game_id, :plateforme_id)";
            $query = $db->prepare($sql_add_plateforme);

            // Parcourt chaque plateforme cochée et l'ajoute à la table de liaison ou Parcourt le tableau plateformeIds et chaque ligne du tableau on récupère dans le jeu créé l'id coché
            foreach ($_POST['plateformeIds'] as $plateforme_id) {
                $query->execute([':game_id' => $game_id, ':plateforme_id' => (int) $plateforme_id]);
            }
        }

        // Affiche une alerte de succès et redirige vers la page admin
        echo "<script>
                    alert('Les données ont été insérées avec succès.');
                    window.location.href = 'jeux.php'; // Redirection vers la page admin
                  </script>";
        exit(); // Stoppe le script après la redirection
    } catch (Exception $e) {
        // Affiche une erreur en cas d'exception SQL
        echo "<script>alert(" . json_encode('Erreur SQL : ' . $e->getMessage()) . ");</script>";
    }
}

?>

<?php include "./template/navbar.php"; ?>
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
                            <label class="uploadlabel" for="background" class="uploadImg">Uploader le background</label>
                            <input type="file" id="background" name="background" class="image" required onchange="previewImage(this, 'backgroundPreview')">
                            <div class="preview" id="backgroundPreview"></div>
                        </div>
                    </div>
                    <div class="container-right">
                        <div class="container-image">
                            <label class="uploadlabel" for="jacket" class="uploadImg">Uploader la jaquette</label>
                            <input type="file" id="jacket" name="jacket" class="image" required onchange="previewImage(this, 'jacketPreview')">
                            <div class="preview" id="jacketPreview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image1"
                                class="uploadImage">Uploader image 1</label>
                            <input type="file" id="image1" name="image1" class="image" required onchange="previewImage(this, 'image1Preview')">
                            <div class="preview" id="image1Preview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image2" class="uploadImage">Uploader image 2</label>
                            <input type="file" id="image2" name="image2" class="image" required onchange="previewImage(this, 'image2Preview')">
                            <div class="preview" id="image2Preview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image3" class="uploadImage">Uploader image 3</label>
                            <input type="file" id="image3" name="image3" class="image" required onchange="previewImage(this, 'image3Preview')">
                            <div class="preview" id="image3Preview"></div>
                        </div>
                        <div class="container-image">
                            <label class="uploadlabel" for="image4" class="uploadImage">Uploader image 4</label>
                            <input type="file" id="image4" name="image4" class="image" required onchange="previewImage(this, 'image4Preview')">
                            <div class="preview" id="image4Preview"></div>
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
                </tr>

            </thead>
            <?php foreach ($games as $game) { ?>
                <tbody>
                    <tr data-page="1">
                        <td class="actions">
                            <a href="editjeux.php?id=<?= $game["game_id"] ?>" class="btn-edit">Modifier</a>
                            <a href="deletejeu.php?id=<?= $game["game_id"] ?>" class="btn-delete">Supprimer</a>
                        </td>
                        <td><?= $game["game_title"] ?></td>
                        <td><?= $game["pseudo"] ?></td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
        <!-- PAGINATION -->
        <div id="pagination" class="container-pages">
            <span id="pageNumbers"></span>
        </div>
        <button class="deleteall">Supprimer tout</button>
    </section>
</main>
</body>
<script src="./js/dropdown.js"></script>
<script src="./js/pagination.js"></script>
<script src="./js/previewgame.js"></script>

</html>

<!-- TO DO LiST 

- Afficher la jacket dans le carrousel
- Afficher la review sur l'index
- faire la messagerie
- faire la politique de conf
- mention légal

-->