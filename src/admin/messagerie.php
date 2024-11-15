<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

?>

<?php include "./template/navbar.php"; ?>
<main>
    <section class="dashboard">
        <h2>Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Aperçu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php foreach ($messages as $message) { ?>
                <tbody>
                    <tr data-page="1">
                        <td class="openmail"><?= $message["name"] ?></a></td>
                        <?php if ($message["lu"] === "unread") { ?>
                            <td><a href="read.php?id=<?= $message["message_id"] ?>"><img src="./img/logos/mail.svg" alt="non lu"></a></td>
                        <?php } else { ?>
                            <td><a href="read.php?id=<?= $message["message_id"] ?>"><img src="./img/logos/mail-open.svg" alt="lu"></a></td>
                        <?php } ?>
                        <td class="actions">
                            <a href="deletemessage.php?id=<?= $message["message_id"] ?>" class="btn-delete">Supprimer</a>
                        </td>
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