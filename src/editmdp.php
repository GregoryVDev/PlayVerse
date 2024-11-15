<?php
session_start();

if (!isset($_SESSION["user_gamer"])) {
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["ancien_pass"], $_POST["new_pass"], $_POST["pass_confirm"]) && !empty($_POST["ancien_pass"]) && !empty($_POST["new_pass"]) && !empty($_POST["pass_confirm"])) {

        require_once("./connect.php");

        $user_id = strip_tags($_SESSION["user_gamer"]["user_id"]);

        $sql = "SELECT pass FROM users WHERE user_id = :user_id";

        $query = $db->prepare($sql);
        $query->bindValue(":user_id", $user_id);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST["ancien_pass"], $user["pass"])) {

            if (isset($_POST["new_pass"]) && isset($_POST["pass_confirm"])) {
                $new_pass = $_POST["new_pass"];
                $pass_confirm = $_POST["pass_confirm"];
            }

            // Vérification des critères du mot de passe
            $passwordPattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{6,}$/";
            if (!preg_match($passwordPattern, $new_pass)) {
                $errorMessage = "Le mot de passe doit contenir :
                <ul style='color: var(--colorPara);'>
                    <li>- Au moins une lettre majuscule</li>
                    <li>- Au moins une lettre minuscule</li>
                    <li>- Au moins un chiffre</li>
                    <li>- Au moins un caractère spécial</li>
                    <li>- 16 caractères minimum</li>
                </ul>";
            } elseif ($new_pass === $pass_confirm) {
                $new_pass = password_hash($_POST["new_pass"], PASSWORD_ARGON2ID);

                $sql_edit = "UPDATE users SET pass=:new_pass WHERE user_id = :user_id";

                $query_edit = $db->prepare($sql_edit);
                $query_edit->bindValue(":new_pass", $new_pass);
                $query_edit->bindValue(":user_id", $user_id);
                $query_edit->execute();

                $succesMessage = "Mot de passe mis à jour avec succès";
            } else {
                $errorMessage = "Les mots de passe ne correspondent pas.";
            }
        } else {
            $errorMessage = "Ton mot de passe actuel n'est pas correct.";
        }
    } else {
        $errorMessage = "Formulaire incomplet";
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
            <?php if (isset($succesMessage)) { ?>
                <div class="success-message"><?php echo $succesMessage ?></div>
            <?php } elseif (isset($errorMessage)) { ?>
                <div class="error-message"><?php echo $errorMessage ?></div>
            <?php } ?>
            <div class="container-title">
                <label for="password">Mot de passe actuel :</label>
                <input type="password" placeholder="Mot de passe actuel" name="ancien_pass">
            </div>
            <div class="container-title">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" placeholder="Nouveau mot de passe" name="new_pass">
            </div>
            <div class="container-title">
                <label for="password">Confirmation du mot de passe</label>
                <input type="password" placeholder="Confirmation nouveau mot de passe" name="pass_confirm">
            </div>
            <button type="submit" class="send">Envoyer</button>
        </form>
    </section>
</main>
</body>
<script src="./js/burger.js"></script>

</html>

<!-- SELECT * FROM users WHERE pass = $_POST['ancien_motdepasse'] && user_id['user_id'];  -->