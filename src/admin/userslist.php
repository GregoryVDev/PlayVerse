<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

$sql = "SELECT * FROM users";

$query = $db->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

require_once("../close.php");

?>

<?php include "./template/navbar.php"; ?>

<section class="page">
    <h1>Gestions des utilisateurs</h1>
</section>
<section class="illustration-user"></section>
<section class="dashboard">
    <h2>Dashboard</h2>

    <div class="container-search">
        <img src="../img/logos/search.svg" alt="Search">
        <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
    </div>

    <table style="margin-top: 50px;">
        <thead>
            <tr>
                <th>Action</th>
                <th>Pseudo</th>
                <th><input type="checkbox"></th>
            </tr>
        </thead>
        <?php foreach ($users as $user) { ?>
            <tbody>
                <tr data-page="1">
                    <td class="actions">
                        <a href="deleteuser.php?id=<?= $user["user_id"] ?>" class="btn-delete">Supprimer</a>
                    </td>
                    <td><?= $user["pseudo"] ?></td>
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
<script src="./js/pagination.js"></script>

</html>