<?php
session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: ../index.php");
    exit();
}

// Fonction de validation d'email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["new_email"], $_POST["confirm"]) && !empty($_POST["new_email"]) && !empty($_POST["confirm"])) {

        // Vérifier si les deux emails correspondent
        if ($_POST["new_email"] === $_POST["confirm"]) {

            // Vérifier si l'email est valide
            if (validateEmail($_POST["new_email"])) {

                require_once("../connect.php");

                // Vérifier si l'email existe déjà dans la table admins
                $sql_check_email = "SELECT COUNT(*) FROM admins WHERE email = :email AND admin_id != :admin_id";
                $query_email = $db->prepare($sql_check_email);
                $query_email->bindValue(":email", $_POST["new_email"]);
                $query_email->bindValue(":admin_id", $_SESSION["admin_gamer"]["admin_id"]);
                $query_email->execute();
                $count_email = $query_email->fetchColumn();

                if ($count_email > 0) {
                    $errorMessage = "L'adresse mail est déjà utilisée par un autre administrateur.";
                }

                // Si aucune erreur n'a été trouvée, mettre à jour l'email
                if (!isset($errorMessage)) {
                    $admin_id = strip_tags($_SESSION["admin_gamer"]["admin_id"]);
                    $sql_edit = "UPDATE admins SET email=:new_email WHERE admin_id=:admin_id";

                    $query_edit = $db->prepare($sql_edit);
                    $query_edit->bindValue(":new_email", $_POST["new_email"]);
                    $query_edit->bindValue(":admin_id", $admin_id);
                    $query_edit->execute();

                    // Vérification si l'email a bien été mis à jour
                    if ($query_edit->rowCount() > 0) {
                        $succesMessage = "Votre email a bien été modifié.";
                    } else {
                        $errorMessage = "L'adresse email n'a pas été mise à jour.";
                    }
                }
            } else {
                $errorMessage = "Veuillez entrer une adresse email valide.";
            }
        } else {
            $errorMessage = "Les deux emails ne correspondent pas.";
        }
    } else {
        $errorMessage = "Formulaire incomplet.";
    }
}
?>

<?php include "./template/navbar.php" ?>

<main>
    <section class="page">
        <h1>Modifier mon adresse email</h1>
    </section>
    <section class="formulaire-email">
        <form action="" method="POST" id="edit">
            <!-- Afficher les messages -->
            <?php if (isset($succesMessage)) { ?>
            <div class="success-message"><?= htmlspecialchars($succesMessage) ?></div>
            <?php } elseif (isset($errorMessage)) { ?>
            <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
            <?php } ?>
            <div class="container-title">
                <label for="email">Nouvelle adresse email :</label>
                <input type="email" name="new_email" placeholder="Nouvelle adresse email" required>
            </div>
            <div class="container-title">
                <label for="email">Confirmation adresse email :</label>
                <input type="email" name="confirm" placeholder="Confirmation adresse email" required>
            </div>
            <button type="submit" class="send">Envoyer</button>
        </form>
    </section>
</main>

<script src="./js/burger.js"></script>

</body>

</html>