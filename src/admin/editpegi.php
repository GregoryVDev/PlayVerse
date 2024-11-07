<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $pegi_id = strip_tags($_POST["id"]);
        $pegi_name = strip_tags($_POST["pegi_name"]);
        $ancienne_image = strip_tags($_POST["ancienne_image"]);

        if (!empty($_FILES["pegi_icon"]["name"])) {
            if ($_FILES["pegi_icon"]["error"] === 0) {
                $allowed = [
                    "jpg" => "image/jpeg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png",
                    "webp" => "image/webp"
                ];
                $filename = $_FILES["pegi_icon"]["name"];
                $filetype = $_FILES["pegi_icon"]["type"];
                $filesize = $_FILES["pegi_icon"]["size"];

                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)) {
                    echo "Erreur : format de l'image incorrect";
                    exit();
                }
                $newname = md5(uniqid());
                $newfilename = __DIR__ . "/img/images/$newname.$extension";
                $url_image = "./img/images/$newname.$extension";

                if (!move_uploaded_file($_FILES["pegi_icon"]["tmp_name"], $newfilename)) {
                    echo "L'upload de l'image a échoué";
                    exit();
                }

                if ($filesize > 500 * 1024) {
                    echo "L'image est trop volumineux";
                    exit();
                }

                // Vérifier si l'ancienne image a été supprimé
                if (!unlink($ancienne_image)) {
                    echo "Problème unlink";
                    exit();
                }

                $pegi_icon = $url_image;

                $sql_edit = "UPDATE pegi SET pegi_name=:pegi_name, pegi_icon=:pegi_icon WHERE pegi_id=:pegi_id";

                $query = $db->prepare($sql_edit);
                $query->bindValue(":pegi_icon", $pegi_icon);
            }
        } else {
            $sql_edit = "UPDATE pegi SET pegi_name=:pegi_name WHERE pegi_id=:pegi_id";

            $query = $db->prepare($sql_edit);
        }

        $query->bindValue(":pegi_id", $pegi_id);
        $query->bindValue(":pegi_name", $pegi_name);

        $query->execute();

        require_once("../close.php");

        header("Location: pegis.php");
        exit();
    } else {
        if (isset($_GET["id"])) {
            $pegi_id = strip_tags($_GET["id"]);

            $sql = "SELECT * FROM pegi WHERE pegi_id=:pegi_id";
            $query = $db->prepare($sql);

            $query->bindValue(":pegi_id", $pegi_id);
            $query->execute();

            $edit = $query->fetch();

            // Vérifier si une catégorie a été trouvée
            if (!$edit) {
                header("Location: pegis.php");
                exit();
            }
        }
    }
} else {
    header("Location: panel.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: pegis.php");
    exit();
}

?>
<?php include "./template/navbar.php" ?>
<main>
    <section class="page">
        <h1>Modification des PEGIS</h1>
    </section>
    <section class="formulaire">
        <form action="" method="POST" id="formajout" enctype="multipart/form-data">
            <h4>Modifier un PEGI</h4>
            <div class="container-title">
                <label for="titre">Titre :</label>
                <input type="text" placeholder="Titre du PEGI" name="pegi_name" id="title" value="<?= $edit["pegi_name"] ?>" required>
            </div>
            <div class="container-icon">
                <label class="uploadlabel" for="icon" id="uploadLabel">Uploader icon du PEGI</label>
                <input type="file" id="icon" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
                <img id="previewImage" src="#" alt="Aperçu de l'image" style="max-width: 100%; display: none;">
                <button type="button" id="deleteImageButton" style="display: none;">Supprimer</button>
            </div>
            <button type="submit" class="send">Modifier le PEGI</button>

            <input type="hidden" name="id" value="<?= $edit['pegi_id'] ?>">
            <input type="hidden" name="ancienne_image" value="<?= $edit['pegi_icon'] ?>">
        </form>
    </section>
</main>

</body>
<script src="./js/admin.js"></script>

</html>