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

        try {
            require_once("./connect.php");

            // Vérification si le pseudo existe déjà
            $sql_check_pseudo = "SELECT COUNT(*) FROM users WHERE pseudo = :pseudo";
            $query_pseudo = $db->prepare($sql_check_pseudo);
            $query_pseudo->bindValue(":pseudo", $pseudo);
            $query_pseudo->execute();
            $count_pseudo = $query_pseudo->fetchColumn();

            if ($count_pseudo > 0) {
                die("Le pseudo est déjà utilisé. Veuillez en choisir un autre.");
            }

            // Vérification si l'email existe déjà
            $sql_check_email = "SELECT COUNT(*) FROM users WHERE email = :email";
            $query_email = $db->prepare($sql_check_email);
            $query_email->bindValue(":email", $_POST["email"]);
            $query_email->execute();
            $count_email = $query_email->fetchColumn();

            if ($count_email > 0) {
                die("L'adresse email est déjà utilisée. Veuillez en choisir une autre.");
            }



            // Vérifier si l'email ou le pseudo existent déjà
            $sql_check = "SELECT COUNT(*) FROM users WHERE email = :email OR pseudo = :pseudo";
            $query_check = $db->prepare($sql_check);
            $query_check->bindValue(":email", $_POST["email"]);
            $query_check->bindValue(":pseudo", $pseudo);
            $query_check->execute();
            // On récupère les colonnes des emails et des pseudos
            $count = $query_check->fetchColumn();

            if ($count > 0) {
                die("L'email ou le pseudo est déjà utilisé. Veuillez en choisir un autre.");
            }

            $sql = "INSERT INTO users (pseudo, email, pass) VALUES (:pseudo, :email, '$pass')";

            $query = $db->prepare($sql);

            $query->bindValue(":pseudo", $pseudo);
            $query->bindValue(":email", $_POST["email"]);

            $query->execute();

            header("Location: connexion.php");
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    } else {
        die("Le formulaire est incomplet");
    }
}



?>
<?php include "./template/navbar.php" ?>
<main>
    <h1 class="titre">Inscription</h1>
    <div class="container-inscription">
        <form method="POST" class="form-login">
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
                        J'accepte <a href="privacy.php" class="politique">la politique de confidentialité</a></label>
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
<script src="./js/login.js"></script>
<script src="./js//burger.js"></script>


</html>