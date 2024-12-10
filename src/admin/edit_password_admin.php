<?php
session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["ancien_pass"], $_POST["new_pass"], $_POST["pass_confirm"]) && !empty($_POST["ancien_pass"]) && !empty($_POST["new_pass"]) && !empty($_POST["pass_confirm"])) {

        require_once("../connect.php");

        $admin_id = strip_tags($_SESSION["admin_gamer"]["admin_id"]);

        // Vérifier si le mot de passe actuel est correct
        $sql = "SELECT pass FROM admins WHERE admin_id = :admin_id";
        $query = $db->prepare($sql);
        $query->bindValue(":admin_id", $admin_id);
        $query->execute();

        $admin = $query->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le mot de passe actuel est correct
        if ($admin && password_verify($_POST["ancien_pass"], $admin["pass"])) {

            // Vérifier si le nouveau mot de passe et la confirmation correspondent
            if ($_POST["new_pass"] === $_POST["pass_confirm"]) {

                // Hasher le nouveau mot de passe
                $new_pass = password_hash($_POST["new_pass"], PASSWORD_ARGON2ID);

                // Mettre à jour le mot de passe dans la table admins
                $sql_edit = "UPDATE admins SET pass = :new_pass WHERE admin_id = :admin_id";
                $query_edit = $db->prepare($sql_edit);
                $query_edit->bindValue(":new_pass", $new_pass);
                $query_edit->bindValue(":admin_id", $admin_id);
                $query_edit->execute();

                // Vérification si le mot de passe a bien été mis à jour
                if ($query_edit->rowCount() > 0) {
                    $succesMessage = "Mot de passe mis à jour avec succès.";
                } else {
                    $errorMessage = "Le mot de passe n'a pas été mis à jour.";
                }
            } else {
                $errorMessage = "Les mots de passe ne correspondent pas.";
            }
        } else {
            $errorMessage = "Votre mot de passe actuel est incorrect.";
        }
    } else {
        $errorMessage = "Formulaire incomplet.";
    }
}
?>

<?php include "./template/navbar.php" ?>

<main>
    <section class="page">
        <h1>Modifier mon mot de passe</h1>
    </section>
    <section class="formulaire-mdp">
        <form action="" method="POST" id="edit">
            <!-- Affichage des messages -->
            <?php if (isset($succesMessage)) { ?>
            <div class="success-message"><?= htmlspecialchars($succesMessage) ?></div>
            <?php } elseif (isset($errorMessage)) { ?>
            <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
            <?php } ?>

            <div class="container-title">
                <label for="ancien_pass">Mot de passe actuel :</label>
                <input type="password" name="ancien_pass" placeholder="Mot de passe actuel" required>
            </div>

            <div class="container-title">
                <label for="new_pass">Nouveau mot de passe :</label>
                <input type="password" name="new_pass" placeholder="Nouveau mot de passe" required>
            </div>

            <div class="container-title">
                <label for="pass_confirm">Confirmation du mot de passe :</label>
                <input type="password" name="pass_confirm" placeholder="Confirmation du mot de passe" required>
            </div>

            <button type="submit" class="send">Envoyer</button>
        </form>
    </section>
</main>

<script src="./js/burger.js"></script>

</body>

</html>