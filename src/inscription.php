<?php

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if (!empty($_POST)) {
    if (isset($_POST["pseudo"], $_POST["email"], $_POST["pass"], $_POST["pass2"], $_POST["terms"]) && !empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST["pass"]) && !empty($_POST["pass2"]) && !empty($_POST["terms"])) {

        $pseudo = strip_tags($_POST["pseudo"]);

        if (!validateEmail($_POST["email"])) {
            die("L'adresse email est incorrect");
        }

        if (isset($_POST["pass"]) && isset($_POST["pass2"])) {
            $pass = $_POST["pass"];
            $pass2 = $_POST["pass2"];
        }

        if ($pass === $pass2) {
            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
        } else {
            die("Les mots de passes ne correspondent pas");
        }

        require_once("./connect.php");

        $sql = "INSERT INTO users (pseudo, email, pass) VALUES (:pseudo, :email, '$pass')";

        $query = $db->prepare($sql);

        $query->bindValue(":pseudo", $pseudo);
        $query->bindValue(":email", $_POST["email"]);

        $query->execute();

        header("Location: connexion.php");
    } else {
        die("Le formulaire est incomplet");
    }
}

?>
<? include "./template/navbar.php" ?>
<main>
    <h1>Inscription</h1>
    <div class="container-inscription">
        <form method="POST">
            <div class="container-pseudo">
                <label for="pseudo">Pseudo :</label>
                <input type="text" class="form-input" name="pseudo" id="pseudo" placeholder="Pseudo">
            </div>
            <div class="container-email">
                <label for="email">Email :</label>
                <input type="email" class="form-input" name="email" id="email" placeholder="Email">
            </div>
            <div class="container-password">
                <label for="pass">Mot de passe :</label>
                <input type="password" class="form-input" name="pass" id="pass" placeholder="Mot de passe">
                <img src="./img/logos/eye.svg" alt="Afficher/Masquer mot de passe" id="myPass" class="toggle-password">
            </div>
            <div class="container-confirm">
                <label for="pass2">Confirmation :</label>
                <input type="password" class="form-input" name="pass2" id="pass2" placeholder="Confirmation mot de passe">
                <img src="./img/logos/eye.svg" alt="Afficher/Masquer mot de passe" id="myPassConfirm" class="toggle-password">
            </div>
            <div class="container-general">
                <div class="container-politique">
                    <label for="checkbox" class="custom-checkbox">
                        J'accepte <a href="#" class="politique">la politique de confidentialité</a></label>
                    <input type="checkbox" id="checkbox" name="terms">
                </div>
                <div class="container-paragraph">
                    <a href="connexion.php">Déjà un compte ?</a>
                </div>
            </div>
            <button type="submit" id="envoie">S'inscrire</button>
        </form>
        <img src="./img/images/arbiter.png" alt="Halo" class="halo">
    </div>
</main>
</body>
<script src="./js/script.js"></script>

</html>