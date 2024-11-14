<?php
session_start();

if (!isset($_SESSION["user_gamer"])) {
    header("Location: index.php");
}

// Condition voir si le formulaire a bien été rempli

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["new_email"], $_POST["confirm"]) && !empty($_POST["new_email"]) && !empty($_POST["confirm"])) {



        if ($_POST["new_email"] === $_POST["confirm"]) {

            if (validateEmail($_POST["new_email"])) {

                require_once("./connect.php");

                $user_id = strip_tags($_SESSION["user_gamer"]["user_id"]);
                $sql_edit = "UPDATE users SET email=:new_email WHERE user_id=:user_id";

                $query_edit = $db->prepare($sql_edit);
                $query_edit->bindValue(":new_email", $_POST["new_email"]);
                $query_edit->bindValue(":user_id", $user_id);
                $query_edit->execute();

                // Mettre une 2e couche de sécurité en comptant après l'execute le nombre de ligne qui a été modifié. Si au minimum 1 ligne a changé, alors la modification a bien été pris en compte
                if ($query_edit->rowCount() > 0) {

                    $succesMessage = "Votre email a bien été modifié.";
                } else {

                    $errorMessage = "L'adresse email n'a pas été mise à jour.";
                }
            } else {

                $errorMessage = "Veuillez rentrer une adresse email.";
            }
        } else {

            $errorMessage = "Les deux emails ne correspondent pas.";
        }
    } else {

        $errorMessage = "Formulaire incomplet";
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
            <div class="container-title">
                <label for="email">Nouvelle adresse email :</label>
                <input type="email" name="new_email" placeholder="Nouvelle adresse email">
            </div>
            <div class="container-title">
                <label for="email">Confirmation adresse email :</label>
                <input type="email" name="confirm" placeholder="Confirmation adresse email">
            </div>
            <button type="submit" class="send">Envoyer</button>
        </form>
    </section>
</main>
</body>
<script src="./js/burger.js"></script>

</html>