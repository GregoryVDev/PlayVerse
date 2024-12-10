<?php
session_start();

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if (!empty($_POST)) {

    if (isset($_POST["email"], $_POST["pass"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {
        if (!validateEmail($_POST["email"])) {
            $errorMessage = "L'adresse email est incorrect.";
        } else {
            require_once("./connect.php");

            // On vérifie si le mail est bien celui d'un admin 
            $sql_search = "SELECT * FROM admins WHERE email = :email";
            $query = $db->prepare($sql_search);
            $query->bindValue(":email", $_POST["email"]);
            $query->execute();
            $admin = $query->fetch();

            if (!$admin) {
                // Recherche dans la table users si l'email n'est pas admin
                $sql_user = "SELECT * FROM users WHERE email = :email";
                $query = $db->prepare($sql_user);
                $query->bindValue(":email", $_POST["email"]);
                $query->execute();
                $user = $query->fetch();

                if ($user) {
                    // Vérification du mot de passe avant de créer la session
                    if (password_verify($_POST["pass"], $user["pass"])) {
                        // Si le mot de passe est correct, on crée la session
                        $_SESSION["user_gamer"] = [
                            "user_id" => $user["user_id"],
                            "pseudo" => $user["pseudo"],
                            "email" => $user["email"],
                            "user" => true
                        ];

                        header("Location: index.php");
                        exit();
                    } else {
                        $errorMessage = "L'adresse email et/ou le mot de passe est incorrect.";
                    }
                } else {
                    // Si aucun compte trouvé, afficher un message
                    $errorMessage = "L'adresse email et/ou le mot de passe est incorrect.";
                }
            } else {
                // Si c'est un admin, afficher un message indiquant une erreur
                $errorMessage = "L'adresse email et/ou le mot de passe est incorrect.";
            }
        }
    } else {
        $errorMessage = "Formulaire incomplet";
    }
}


?>
<?php include "./template/navbar.php" ?>
<main>
    <h1 class="titre">Connexion</h1>
    <div class="container-connexion">
        <form method="POST" class="form-login">
            <?php if (!empty($errorMessage)): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <div class="container-email">
                <label for="email">Email :</label>
                <input type="email" class="form-input" name="email" id="email" placeholder="Email">
            </div>
            <div class="container-password">
                <label for="pass">Mot de passe :</label>
                <input type="password" class="form-input" name="pass" id="passCo" placeholder="Mot de passe">
                <img src="./img/logos/eye.svg" alt="Afficher/Masquer mot de passe" id="passConnect"
                    class="toggle-password">
            </div>
            <div class="container-para">
                <div class="container-compte">
                    <a href="inscription.php">Pas de compte ?</a>
                </div>
                <div class="container-paragraph">
                    <a href="#">Mot de passe oublié</a>
                </div>
            </div>
            <button type="submit" id="envoie">Se connecter</button>
        </form>
        <img src="./img/images/combat-arms.webp" alt="Combat Arms" class="ca">
    </div>
</main>
</body>
<script src="./js/login.js"></script>
<script src="./js//burger.js"></script>
<script src="./js/script.js"></script>

</html>