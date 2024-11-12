<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

require_once("../connect.php");

$sql = "SELECT * FROM message";

$query = $db->prepare($sql);
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include "./template/navbar.php"; ?>
<main>
    <section class="dashboard">
        <h2>Dashboard</h2>

        <div class="container-search">
            <img src="../img/logos/search.svg" alt="Search">
            <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Aperçu</th>
                    <th>Action</th>
                    <th><input type="checkbox"></th>
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