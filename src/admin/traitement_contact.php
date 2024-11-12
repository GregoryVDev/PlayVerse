<!-- TO DO LIST

- Mettre un action avec la page qui traite le formulaire (donc celle-ci)
- Je récupère les messages, REQUETE INSERT INTO message pour les mettres dans la bdd
- il (user) va se retrouver sur traitement_contact.php et mettre un location header ici pour le renvoyer sur l'index avec une alerte message envoyé

-->
<?php


require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST)) {

        if (isset($_POST["name"], $_POST["firstname"], $_POST["email"], $_POST["object"], $_POST["message"])) {

            $name = strip_tags($_POST["name"]);
            $firstname = strip_tags($_POST["firstname"]);
            $email = strip_tags($_POST["email"]);
            $object = strip_tags($_POST["object"]);
            $message = strip_tags($_POST["message"]);

            // Définir la date d'aujourd'hui
            $date_message = date("Y-m-d H:i:s");

            $sql_add = "INSERT INTO `message` (name, firstname, email, object, message, date_message) VALUES (:name, :firstname, :email, :object, :message, :date_message)";

            $query = $db->prepare($sql_add);
            $query->bindValue(":name", $name);
            $query->bindValue(":firstname", $firstname);
            $query->bindValue(":email", $email);
            $query->bindValue(":object", $object);
            $query->bindValue(":message", $message);
            $query->bindValue(":date_message", $date_message);

            $query->execute();

            // Exécution de la requête et vérification du succès
            if ($query->execute()) {
                echo "<script>alert('Message envoyé avec succès'); window.location.href='../index.php';</script>";
            } else {
                // Affiche une alerte si la requête échoue
                echo "<script>alert('Erreur lors de l'envoi du message.');</script>";
            }

            require_once("../close.php");
            header("Location: ../index.php");
            exit();
        }
    } else {
        echo "<script>
        alert('Echec, mail non envoyé.');
        window.location.href = '../index.php'; // Redirection vers la page admin
      </script>";
    }
}
?>