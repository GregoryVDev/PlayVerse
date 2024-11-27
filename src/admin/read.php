<?php

session_start();

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
    exit();
}

require_once("../connect.php");

// Vérification que l'ID est bien passé dans l'URL et non vide
if (!isset($_GET["id"]) && empty($_GET["id"])) {
    header("Location: messagerie.php");
    exit();
}

// Nettoie l'ID et s'assure qu'il est un entier
$id = (int) strip_tags($_GET["id"]);

// Requête pour récupérer le message correspondant
$sql_messages = "SELECT * FROM message WHERE message_id = :message_id";
$query_messages = $db->prepare($sql_messages);
$query_messages->bindValue(":message_id", $id, PDO::PARAM_INT);
$query_messages->execute();
$messages_read = $query_messages->fetch(PDO::FETCH_ASSOC);

// Vérification si le message existe
if ($messages_read && count($messages_read) > 0) {

    // Vérification du statut "lu" et mise à jour si nécessaire
    if ($messages_read['lu'] === "unread") {
        $sql_update = "UPDATE message SET lu = 'read' WHERE message_id = :message_id";
        $update_query = $db->prepare($sql_update);
        $update_query->bindValue(":message_id", $id, PDO::PARAM_INT);
        $update_query->execute();
    }
} else {
    // Alerte si l'ID est invalide ou si le message n'existe pas
    echo "<script>alert('ID invalide ou message introuvable.'); window.location.href = 'messagerie.php';</script>";
    exit();
}

require_once("../close.php");

?>

<?php include "./template/navbar.php" ?>

<main>

    <div class="container-messages">
        <div class="date">
            <p><?=
                // strtotime permet de reformater la date sur le css (pas en bdd)
                date("d-m-Y", strtotime($messages_read["date_message"])) ?></p>
        </div>
        <div class="name">
            <p><?= $messages_read["name"] ?></p>
        </div>
        <div class="firstname">
            <p><?= $messages_read["firstname"] ?></p>
        </div>
        <div class="email">
            <p><a href="mailto:<?= $messages_read["email"] ?>"><?= $messages_read["email"] ?></a></p>
        </div>
        <div class="message">
            <p><?= $messages_read["message"] ?></p>
        </div>

        <button class="deleteall"><a href="deletemessage.php?id=<?= $messages_read["message_id"] ?>">Supprimer le message</a></button>
        <a href="./messagerie.php" class="retour">Retour</a>
    </div>
</main>