<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["id"])) {
            $category_id = strip_tags($_POST["id"]);
            $category_name = strip_tags($_POST["category_name"]);

            $sql_edit = "UPDATE category SET category_name = :category_name WHERE category_id = :category_id";

            $query = $db->prepare($sql_edit);

            $query->bindValue(":category_id", $category_id);
            $query->bindValue(":category_name", $category_name);

            $query->execute();
            require_once("../close.php");

            header("Location: categories.php");
            exit();
        }
    } else {
        if (isset($_GET["id"])) {
            $category_id = strip_tags($_GET["id"]);

            $sql = "SELECT * FROM category WHERE category_id=:category_id";
            $query = $db->prepare($sql);

            $query->bindValue(":category_id", $category_id);
            $query->execute();

            $edit = $query->fetch();

            // Vérifier si une catégorie a été trouvée
            if (!$edit) {
                header("Location: categories.php");
                exit();
            }
        }
    }
} else {
    header("Location: panel.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: categories.php");
    exit();
}


?>

<?php include "./template/navbar.php" ?>
<main>
    <section class="page">
        <h1>Modification des Catégories</h1>
    </section>
    <section class="formulaire">
        <form action="" method="POST" id="formajout" enctype="multipart/form-data">
            <h4>Modifier une catégorie</h4>
            <div class="container-title">
                <label for="titre">Nom :</label>
                <input type="text" placeholder="Nom de la catégorie" name="category_name" id="title" value="<?= $edit["category_name"] ?>" style="margin-bottom: 20px;" required>
            </div>
            <button type="submit" class="send">Modifier la catégorie</button>
        </form>
    </section>
</main>

</body>
<script src="./js/admin.js"></script>

</html>