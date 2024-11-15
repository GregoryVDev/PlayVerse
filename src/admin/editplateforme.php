<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $plateforme_id = strip_tags($_POST["id"]);
        $plateforme_name = strip_tags($_POST["plateforme_name"]);
        $ancienne_image = strip_tags($_POST["ancienne_image"]);

        if (!empty($_FILES["plateforme_icon"]["name"])) {
            if ($_FILES["plateforme_icon"]["error"] === 0) {
                $allowed = [
                    "jpg" => "image/jpeg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png",
                    "webp" => "image/webp"
                ];
                $filename = $_FILES["plateforme_icon"]["name"];
                $filetype = $_FILES["plateforme_icon"]["type"];
                $filesize = $_FILES["plateforme_icon"]["size"];

                // Vérifier la taille avant de procéder à toute autre action
                if ($filesize > 500 * 1024) {
                    echo "L'image est trop volumineuse";
                    exit();
                }

                // Vérifier l'extension et le type de fichier
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                    echo "Erreur : format de l'image incorrect";
                    exit();
                }

                // Générer un nom unique pour l'image
                $newname = md5(uniqid());
                $newfilename = __DIR__ . "/img/images/$newname.$extension";
                $url_image = "./img/images/$newname.$extension";

                // Déplacer le fichier vers le dossier d'images
                if (!move_uploaded_file($_FILES["plateforme_icon"]["tmp_name"], $newfilename)) {
                    echo "L'upload de l'image a échoué";
                    exit();
                }

                // Vérifier si l'ancienne image a été supprimée
                if (!unlink($ancienne_image)) {
                    echo "Problème unlink";
                    exit();
                }

                $plateforme_icon = $url_image;

                // Préparer la requête de mise à jour avec l'icône de la plateforme
                $sql_edit = "UPDATE plateformes SET plateforme_name=:plateforme_name, plateforme_icon=:plateforme_icon WHERE plateforme_id=:plateforme_id";
                $query = $db->prepare($sql_edit);
                $query->bindValue(":plateforme_icon", $plateforme_icon);
            }
        } else {
            // Si aucune nouvelle image n'est téléchargée, on ne met à jour que le nom
            $sql_edit = "UPDATE plateformes SET plateforme_name=:plateforme_name WHERE plateforme_id=:plateforme_id";
            $query = $db->prepare($sql_edit);
        }

        // Lier les valeurs et exécuter la requête
        $query->bindValue(":plateforme_id", $plateforme_id);
        $query->bindValue(":plateforme_name", $plateforme_name);
        $query->execute();

        require_once("../close.php");

        // Redirection après modification
        header("Location: plateformes.php");
        exit();
    } else {
        if (isset($_GET["id"])) {
            $plateforme_id = strip_tags($_GET["id"]);

            // Récupérer les données de la plateforme
            $sql = "SELECT * FROM plateformes WHERE plateforme_id=:plateforme_id";
            $query = $db->prepare($sql);
            $query->bindValue(":plateforme_id", $plateforme_id);
            $query->execute();

            $edit = $query->fetch();

            // Vérifier si une plateforme a été trouvée
            if (!$edit) {
                header("Location: plateformes.php");
                exit();
            }
        }
    }
} else {
    header("Location: panel.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: plateformes.php");
    exit();
}

?>
<?php include "./template/navbar.php" ?>
<main>
    <section class="page">
        <h1>Modification des plateformes</h1>
    </section>
    <section class="formulaire">
        <form action="" method="POST" id="formajout" enctype="multipart/form-data">
            <h4>Modifier une plateforme</h4>
            <div class="container-title">
                <label for="name">Nom :</label>
                <input type="text" placeholder="Nom de la plateforme" name="plateforme_name" id="title" value="<?= $edit["plateforme_name"] ?>" required>
            </div>
            <div class="container-icon">
                <label class="uploadlabel" for="icon" id="uploadLabel">Uploader icon de la plateforme</label>
                <input type="file" id="icon" name="plateforme_icon" class="icon" placeholder="Icon de la plateforme" accept="image/*">
                <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
            </div>
            <button type="submit" class="send">Modifier la plateforme</button>

            <input type="hidden" name="id" value="<?= $edit['plateforme_id'] ?>">
            <input type="hidden" name="ancienne_image" value="<?= $edit['plateforme_icon'] ?>">
        </form>
    </section>
</main>

</body>
<script src="./js/admin.js"></script>

</html>