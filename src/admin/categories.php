<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $category_name = strip_tags($_POST["category_name"]);

        $sql_addcategory = "INSERT INTO category (category_name) VALUES (:category_name)";

        $query = $db->prepare($sql_addcategory);

        $query->bindValue(":category_name", $category_name);

        $query->execute();

        require_once("../close.php");
        header("Location: categories.php");
        exit();
    }
} else {
    header("Location: ../index.php");
}

$sql = "SELECT * FROM category WHERE category_id";
$query = $db->prepare($sql);

$query->execute();

$categories = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include "./template/navbar.php"; ?>
<main>
    <section class="page">
        <h1>Gestions des catégories</h1>
    </section>
    <section class="formulaire">
        <form action="" method="POST" id="formajout" enctype="multipart/form-data">
            <h4>Ajouter une catégorie</h4>
            <div class="container-title">
                <label for="Nom">Nom :</label>
                <input type="text" placeholder="Nom de la catégorie" name="category_name" id="title" style="margin-bottom: 20px;" required>
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
                    <th>Catégorie</th>
                </tr>
            </thead>
            <?php foreach ($categories as $category) { ?>
                <tbody>
                    <tr data-page="1">
                        <td class="actions">
                            <a href="editcategory.php?id=<?= $category["category_id"] ?>" class="btn-edit">Modifier</a>
                            <a href="deletecategory.php?id=<?= $category["category_id"] ?>" class="btn-delete">Supprimer</a>
                        </td>
                        <td><?= $category["category_name"] ?></td>
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