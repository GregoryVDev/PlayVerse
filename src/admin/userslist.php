<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

$sql = "SELECT * FROM users ORDER BY user_id DESC";

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

    <table style="margin-top: 50px;">
        <thead>
            <tr>
                <th>Action</th>
                <th>Pseudo</th>
            </tr>
        </thead>
        <?php foreach ($users as $user) { ?>
            <tbody>
                <tr data-page="1">
                    <td class="actions">
                        <a href="deleteuser.php?id=<?= $user["user_id"] ?>" class="btn-delete">Supprimer</a>
                    </td>
                    <td><?= $user["pseudo"] ?></td>
                </tr>
            </tbody>
        <?php } ?>
    </table>
    <!-- PAGINATION -->
    <div id="pagination" class="container-pages">
        <span id="pageNumbers"></span>
    </div>
</section>
</main>
</body>
<script src="./js/admin.js"></script>
<script src="./js/pagination.js"></script>

</html>