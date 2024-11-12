<?php

// Fonction pour valider l'adresse e-mail
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Vérifie si le formulaire est soumis et non vide
if (!empty($_POST)) {

    // Vérifie que tous les champs nécessaires sont présents et non vides
    if (isset($_POST["pseudo"], $_POST["email"], $_POST["pass"], $_POST["pass2"], $_POST["terms"]) && !empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST["pass"]) && !empty($_POST["pass2"]) && !empty($_POST["terms"])) {

        // Nettoie le champ "pseudo" pour éviter l'injection HTML
        $pseudo = strip_tags($_POST["pseudo"]);

        // Vérifie la validité de l'email
        if (!validateEmail($_POST["email"])) {
            die("L'adresse email est incorrect");
        }

        // Récupère et vérifie les mots de passe
        if (isset($_POST["pass"]) && isset($_POST["pass2"])) {
            $pass = $_POST["pass"];
            $pass2 = $_POST["pass2"];
        }

        if ($pass === $pass2) {
            // Hache le mot de passe pour le sécuriser
            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
        } else {
            die("Les mots de passes ne correspondent pas");
        }

        // Connexion à la base de données
        require_once("../connect.php");

        // Prépare l'insertion des données dans la table "admins"
        $sql = "INSERT INTO admins (pseudo, email, pass) VALUES (:pseudo, :email, '$pass')";

        $query = $db->prepare($sql);

        // Associe les valeurs aux paramètres de la requête SQL
        $query->bindValue(":pseudo", $pseudo);
        $query->bindValue(":email", $_POST["email"]);

        // Exécute la requête
        $query->execute();

        // Redirige vers la page de connexion administrateur
        header("Location: ../admin/connexionadmin.php");
    } else {
        die("Le formulaire est incomplet");
    }
}

?>
<? include "../template/navbar.php" ?>
<main>
    <h1 class="titre">Inscription admin</h1>
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
                <img src="../img/logos/eye.svg" alt="Afficher/Masquer mot de passe" id="myPass" class="toggle-password">
            </div>
            <div class="container-confirm">
                <label for="pass2">Confirmation :</label>
                <input type="password" class="form-input" name="pass2" id="pass2"
                    placeholder="Confirmation mot de passe">
                <img src="../img/logos/eye.svg" alt="Afficher/Masquer mot de passe" id="myPassConfirm"
                    class="toggle-password">
            </div>
            <div class="container-general">
                <div class="container-politique">
                    <label for="checkbox" class="custom-checkbox">
                        J'accepte <a href="../privacy.php" class="politique">la politique de confidentialité</a></label>
                    <input type="checkbox" id="checkbox" name="terms">
                </div>
                <div class="container-paragraph">
                    <a href="connexionadmin.php">Déjà un compte ?</a>
                </div>
            </div>
            <button type="submit" id="envoie">S'inscrire</button>
        </form>
        <img src="../admin/img/csgo.png" alt="csgo" class="halo">
    </div>
</main>
</body>
<script src="../js/login.js"></script>
<script src="../js//burger.js"></script>


</html>