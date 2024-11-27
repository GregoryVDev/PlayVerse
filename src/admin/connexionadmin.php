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
            require_once("../connect.php");

            // On vérifie si le mail est bien celui d'un user 
            $sql_search = "SELECT * FROM users WHERE email = :email";
            $query = $db->prepare($sql_search);
            $query->bindValue(":email", $_POST["email"]);
            $query->execute();
            $user = $query->fetch();



            if (!$user) {
                // Rechercher dans la table admins si l'email n'est pas celui d'un user
                $sql_user = "SELECT * FROM admins WHERE email = :email";
                $query = $db->prepare($sql_user);

                $query->bindValue(":email", $_POST["email"]);

                $query->execute();

                $admin = $query->fetch();

                if ($admin) {
                    // Vérification du mot de passe avant de créer la session
                    if (password_verify($_POST["pass"], $admin["pass"])) {
                        // Si le mot de passe est correct, on crée la session
                        $_SESSION["admin_gamer"] = [
                            "admin_id" => $admin["admin_id"],
                            "pseudo" => $admin["pseudo"],
                            "email" => $admin["email"],
                            "admin" => true
                        ];

                        header("Location: panel.php");
                        exit();
                    } else {
                        $errorMessage = "L'adresse email et/ou le mot de passe est incorrect.";
                    }
                } else {
                    // Si aucun compte trouvé, afficher un message
                    $errorMessage = "L'adresse email et/ou le mot de passe est incorrect.";
                }
            } else {
                $errorMessage = "L'adresse email et/ou le mot de passe est incorrect.";
            }
        }
    } else {
        $errorMessage = "Formulaire incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../css/fonts.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./css/panel.css">
    <link rel="stylesheet" href="./css/utilisateurs.css">
    <link rel="stylesheet" href="./css/message.css">
    <link rel="stylesheet" href="./css/gestions.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>PlayVerse</title>
</head>

<body>
    <main>
        <h1 class="titre">Connexion <span class="connexion-color-admin">admin</span></h1>
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
                    <img src="../img/logos/eye.svg" alt="Afficher/Masquer mot de passe" id="passConnect"
                        class="toggle-password">
                </div>
                <div class="container-para">
                </div>
                <button type="submit" id="envoie">Se connecter</button>
            </form>
            <img src="../admin/img/thelastofus.png" alt="the last of us" class="ca">
        </div>
    </main>
</body>
<script src="../js/login.js"></script>
<script src="../js//burger.js"></script>
</body>

</html>