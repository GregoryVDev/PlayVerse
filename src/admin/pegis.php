<?php

session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $pegi_name = strip_tags($_POST["pegi_name"]);

        if ($_FILES["pegi_icon"]["error"] === 0) {
            // Vérification des extentions et du type Mime
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
            if (!move_uploaded_file($_FILES["pegi_icon"]["tmp_name"], $newfilename)) {
                echo "L'upload a échoué ";
            }

            // Type est correct
            // On limite à 500Ko (500 * 1024)
            if ($filesize > 500 * 1024) {
                echo "L'image est trop volumineux";
            }
        }

        $pegi_icon = $url_image;

        $sql_addpegi = "INSERT INTO pegi (pegi_name, pegi_icon) VALUES (:pegi_name, :pegi_icon)";

        $query = $db->prepare($sql_addpegi);

        $query->bindValue(":pegi_name", $pegi_name);
        $query->bindValue(":pegi_icon", $pegi_icon);

        $query->execute();

        require_once("../close.php");
        header("Location: pegis.php");

        exit();
    }
} else {
    header("Location: ../index.php");
}

?>

<? include "./template/navbar.php"; ?>
<main>
    <section class="page">
        <h1>Gestions des PEGIS</h1>
    </section>
    <section class="formulaire">
        <form action="" method="POST" id="formajout" enctype="multipart/form-data">
            <h4>Ajouter un PEGI</h4>
            <div class="container-title">
                <label for="titre">Titre :</label>
                <input type="text" placeholder="Titre du PEGI" name="pegi_name" id="title" required>
            </div>
            <div class="container-icon">
                <label class="uploadlabel" for="icon" id="uploadLabel">Uploader icon du PEGI</label>
                <input type="file" id="icon" name="pegi_icon" class="icon" placeholder="Icon du PEGI" accept="image/*" required>
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
            <tbody>
                <tr data-page="1">
                    <td class="actions"><a href="#" class="btn-edit">Modifier</a>
                        <a href="#" class="btn-see">Voir</a>
                        <a href="#" class="btn-delete">Supprimer</a>
                    </td>
                    <td>The Bible</td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
                <tr data-page="1">
                    <td class="actions"><a href="#" class="btn-edit">Modifier</a>
                        <a href="#" class="btn-see">Voir</a>
                        <a href="#" class="btn-delete">Supprimer</a>
                    </td>
                    <td>Harry Potter</td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
                <tr data-page="1">
                    <td class="actions"><a href="#" class="btn-edit">Modifier</a>
                        <a href="#" class="btn-see">Voir</a>
                        <a href="#" class="btn-delete">Supprimer</a>
                    </td>
                    <td>The Lord of the Rings</td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
            </tbody>

        </table>
        <button class="deleteall">Supprimer tout</button>
    </section>
</main>
</body>
<script src="./js/admin.js"></script>
<script>

</script>

</html>




<!-- TO DO LIST
 

- CRUD PEGI
- CRUD Catégorie
- CRUD PLATEFORME
- CRUD JEUX
- MESSAGERIE
- Modification des images des étoiles favoris
- Mettre tous les images en webp

-->