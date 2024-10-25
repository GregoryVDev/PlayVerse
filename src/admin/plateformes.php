<?php

session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $plateforme_name = strip_tags($_POST["plateforme_name"]);

        if ($_FILES["plateforme_icon"]["error"] === 0) {
            // Vérification des extentions et du type Mime
            $allowed = [
                "jpg" => "image/jpeg",
                "jpeg" => "image/jpeg",
                "png" => "image/png",
                "webp" => "image/webp"
            ];

            $filename = $_FILES["plateforme_icon"]["name"];
            $filetype = $_FILES["plateforme_icon"]["type"];
            $filesize = $_FILES["plateforme_icon"]["size"];

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // Vérification de l'absence de l'extension dans $allowed ou absence du type MIME dans les valeurs
            if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                // L'extension soit le type est incorrect
                echo "Erreur: format du projet incorrect";
            }

            // On génère un nom unique
            $newname = md5(uniqid());

            // On génère le chemin complet

            $newfilename = __DIR__ . "/img/images/$newname.$extension";
            $url_image = "./img/images/$newname.$extension";

            // On déplace le fichier de tmp à images en le renommant
            if (!move_uploaded_file($_FILES["plateforme_icon"]["tmp_name"], $newfilename)) {
                echo "L'upload a échoué ";
            }

            // Type est correct
            // On limite à 500Ko (500 * 1024)
            if ($filesize > 500 * 1024) {
                echo "L'image est trop volumineux";
            }
        }

        $plateforme_icon = $url_image;

        $sql_addplat = "INSERT INTO plateformes (plateforme_name, plateforme_icon) VALUES (:plateforme_name, :plateforme_icon)";

        $query = $db->prepare($sql_addplat);

        $query->bindValue(":plateforme_name", $plateforme_name);
        $query->bindValue(":plateforme_icon", $plateforme_icon);

        $query->execute();

        require_once("../close.php");
        header("Location: plateformes.php");
        exit();
    }
} else {
    header("Location: ../index.php");
}

$sql = "SELECT * FROM plateformes WHERE plateforme_id";
$query = $db->prepare($sql);

$query->execute();

$plateformes = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<? include "./template/navbar.php"; ?>
<main>
    <section class="gestion">
        <h1>Gestions des plateformes</h1>
        <img src="./img/drrobotnik.gif" alt="Sonic">
    </section>
    <section class="formulaire">
        <form action="" method="POST" id="formajout" enctype="multipart/form-data">
            <h4>Ajouter une plateforme</h4>
            <div class="container-title">
                <label for="name">Nom :</label>
                <input type="text" placeholder="Nom de la plateforme" name="plateforme_name" id="title" required>
            </div>
            <div class="container-icon">
                <label class="uploadlabel" for="icon" id="uploadLabel">Uploader icon de la plateforme</label>
                <input type="file" id="icon" name="plateforme_icon" class="icon" placeholder="Icon de la plateforme" accept="image/*" required>
                <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
            </div>
            <button type="submit" class="send">Envoyer</button>
        </form>
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
                    <th><input type="checkbox"></th>
                </tr>
            </thead>
            <?php foreach ($plateformes as $plateforme) { ?>
                <tbody>
                    <tr data-page="1">
                        <td class="actions">
                            <a href="editplateforme.php?id=<?= $plateforme["plateforme_id"] ?>" class="btn-edit">Modifier</a>
                            <a href="deleteplateforme.php?id=<?= $plateforme["plateforme_id"] ?>" class="btn-delete">Supprimer</a>
                        </td>
                        <td><?= $plateforme["plateforme_name"] ?></td>
                        <td><label><input type="checkbox"></label></td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
        <button class="deleteall">Supprimer tout</button>
    </section>
</main>
</body>
<script src="./js/admin.js"></script>

</html>




<!-- TO DO LIST
 
- CRUD Catégorie
- CRUD PLATEFORME
- CRUD JEUX
- MESSAGERIE


- Modification des images des étoiles favoris
- Mettre tous les images en webp

-->