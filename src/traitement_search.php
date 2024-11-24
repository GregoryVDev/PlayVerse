<?php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $_GET["search"] = htmlspecialchars(($_GET["search"]));

    $search = strip_tags(($_GET["search"]));

    require_once("./connect.php");

    $search = "%$search%";

    $sql = "SELECT game_id FROM games WHERE game_title LIKE :search";
    $query = $db->prepare($sql);
    $query->bindValue(":search", $search);
    $query->execute();
    $result = $query->fetch();

    if ($result) {
        header("Location: infogame.php?game_id=" . $result["game_id"]);
        exit();
    } else {
        // Si aucun jeu n'est trouvé, affiche une alerte et redirige vers game.php sans paramètre
        echo "<script>
            alert('Aucun résultat trouvé pour ce jeu.');
            window.location.href = 'games.php';
        </script>";
        exit();
    }
}