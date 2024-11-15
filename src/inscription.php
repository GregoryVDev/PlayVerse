<?php

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if (!empty($_POST)) {
    // Vérifiez d'abord si la case "terms" est cochée
    if (!isset($_POST["terms"])) {
        $errorMessage = "Vous devez accepter la politique de confidentialité.";
    } else if (
        isset($_POST["pseudo"], $_POST["email"], $_POST["pass"], $_POST["pass2"])
        && !empty($_POST["pseudo"]) && !empty($_POST["email"])
        && !empty($_POST["pass"]) && !empty($_POST["pass2"])
    ) {

        $pseudo = strip_tags($_POST["pseudo"]);

        if (!validateEmail($_POST["email"])) {
            $errorMessage = "L'adresse mail est incorrecte.";
        }

        if (isset($_POST["pass"]) && isset($_POST["pass2"])) {
            $pass = $_POST["pass"];
            $pass2 = $_POST["pass2"];
        }
        // Vérification des critères du mot de passe
        $passwordPattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{6,}$/";
        if (!preg_match($passwordPattern, $pass)) {
            $errorMessage = "Le mot de passe doit contenir :
            <ul style='color: var(--colorPara);'>
                <li>- Au moins une lettre majuscule</li>
                <li>- Au moins une lettre minuscule</li>
                <li>- Au moins un chiffre</li>
                <li>- Au moins un caractère spécial</li>
                <li>- 16 caractères minimum</li>
            </ul>";
        } elseif ($pass === $pass2) {
            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
        } else {
            $errorMessage = "Les mots de passe ne correspondent pas.";
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
                $errorMessage = "Le pseudo " . htmlspecialchars($_POST['pseudo']) . " est déjà utilisé.";
            }

            // Vérification si l'email existe déjà
            $sql_check_email = "SELECT COUNT(*) FROM users WHERE email = :email";
            $query_email = $db->prepare($sql_check_email);
            $query_email->bindValue(":email", $_POST["email"]);
            $query_email->execute();
            $count_email = $query_email->fetchColumn();

            if ($count_email > 0) {
                $errorMessage = "L'adresse mail est déjà associée à un compte.";
            }

            // Vérification si l'email existe déjà dans la table admin
            $sql_check_pseudo_admin = "SELECT COUNT(*) FROM admins WHERE pseudo = :pseudo";
            $query_pseudo_admin = $db->prepare($sql_check_pseudo_admin);
            $query_pseudo_admin->bindValue(":pseudo", $_POST["pseudo"]);
            $query_pseudo_admin->execute();
            $count_pseudo_admin = $query_pseudo_admin->fetchColumn();

            if ($count_pseudo_admin > 0) {
                $errorMessage = "Le pseudo " . htmlspecialchars($_POST["pseudo"]) . " est déjà utilisée.";
            }

            // Vérification si l'email existe déjà dans la table admin
            $sql_check_email_admin = "SELECT COUNT(*) FROM admins WHERE email = :email";
            $query_email_admin = $db->prepare($sql_check_email_admin);
            $query_email_admin->bindValue(":email", $_POST["email"]);
            $query_email_admin->execute();
            $count_email_admin = $query_email_admin->fetchColumn();

            if ($count_email_admin > 0) {
                $errorMessage = "L'adresse mail est déjà utilisée.";
            }


            // Insertion dans la base de données uniquement s'il n'y a pas d'erreur
            if (empty($errorMessage)) {
                $sql = "INSERT INTO users (pseudo, email, pass) VALUES (:pseudo, :email, :pass)";
                $query = $db->prepare($sql);
                $query->bindValue(":pseudo", $pseudo);
                $query->bindValue(":email", $_POST["email"]);
                $query->bindValue(":pass", $pass);
                $query->execute();

                header("Location: connexion.php");
                exit();
            }
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    } else {
        $errorMessage = "Le formulaire est incomplet.";
    }
}

?>


<?php include "./template/navbar.php" ?>
<main>
    <h1 class="titre">Inscription</h1>
    <div class="container-inscription">
        <form method="POST" class="form-login">
            <!-- Affiche le message d'erreur, si présent -->
            <?php if (!empty($errorMessage)): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
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