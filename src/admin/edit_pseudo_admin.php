<?php
session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["new_pseudo"]) && !empty($_POST["new_pseudo"])) {

        require_once("../connect.php");

        $admin_id = strip_tags($_SESSION["admin_gamer"]["admin_id"]);
        $new_pseudo = $_POST["new_pseudo"];

        // Vérifier si le pseudo existe déjà dans la table admins
        $sql_check_pseudo = "SELECT COUNT(*) FROM admins WHERE pseudo = :pseudo";
        $query_pseudo = $db->prepare($sql_check_pseudo);
        $query_pseudo->bindValue(":pseudo", $new_pseudo);
        $query_pseudo->execute();
        $count_pseudo = $query_pseudo->fetchColumn();

        if ($count_pseudo > 0) {
            $errorMessage = "Ce pseudo est déjà utilisé.";
        } else {
            // Mettre à jour le pseudo dans la table admins
            $sql_edit = "UPDATE admins SET pseudo = :new_pseudo WHERE admin_id = :admin_id";
            $query_edit = $db->prepare($sql_edit);
            $query_edit->bindValue(":new_pseudo", $new_pseudo);
            $query_edit->bindValue(":admin_id", $admin_id);
            $query_edit->execute();

            // Vérification si le pseudo a bien été mis à jour
            if ($query_edit->rowCount() > 0) {
                $succesMessage = "Votre pseudo a été mis à jour avec succès.";
            } else {
                $errorMessage = "Le pseudo n'a pas été mis à jour.";
            }
        }
    } else {
        $errorMessage = "Formulaire incomplet.";
    }
}
?>

<?php include "./template/navbar.php" ?>

<main>
    <section class="page">
        <h1>Modifier mon pseudo</h1>
    </section>
    <section class="formulaire-pseudo">
        <form action="" method="POST" id="edit">
            <!-- Affichage des messages -->
            <?php if (isset($succesMessage)) { ?>
            <div class="success-message"><?= htmlspecialchars($succesMessage) ?></div>
            <?php } elseif (isset($errorMessage)) { ?>
            <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
            <?php } ?>

            <div class="container-title">
                <label for="new_pseudo">Nouveau pseudo :</label>
                <input type="text" name="new_pseudo" placeholder="Nouveau pseudo" required class="input-field">
            </div>

            <button type="submit" class="send">Envoyer</button>
        </form>
    </section>
</main>

<script src="./js/burger.js"></script>

</body>

</html>