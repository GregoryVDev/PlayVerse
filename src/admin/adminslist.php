<?php
session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {

    $sql = "SELECT * FROM admins ORDER BY admin_id DESC";
    $query = $db->prepare($sql);

    $query->execute();

    $admins = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: ../index.php");
}

?>




<?php include "./template/navbar.php"; ?>
<main>

    <section class="page">

        <h1 class="gestion-des-admins">Gestions des admins </h1>
        <a class="btn-add-admin" href="inscriptionadmin.php">Ajouter un admin</a>

    </section>

    <section class="dashboard">
        <h2>Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>admin_id</th>
                    <th>pseudo</th>
                    <th>email</th>
                </tr>
            </thead>
            <?php foreach ($admins as $admin) { ?>
                <tbody>
                    <tr data-page="1">
                        <td class="actions">
                            <a class="btn-delete" href="deleteadmin.php?id=<?= $admin["admin_id"] ?>">Supprimer</a>
                        </td>
                        <td><?= $admin["admin_id"] ?></td>
                        <td><?= $admin["pseudo"] ?></td>
                        <td><?= $admin["email"] ?></td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </section>
</main>
<script src="./js/admin.js"></script>
</body>

</html>