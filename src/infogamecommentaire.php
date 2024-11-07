<?php

session_start();

// Connexion à la base de données
require_once("connect.php");

$game_id = 1; // A REMPLACER PAR : $game_id = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 1

// Récupération des 3 derniers commentaires et pseudos

try {
    // Préparation de la requête SQL avec une jointure entre commentary, users et games
    $query = $db->prepare("
        SELECT c.message, u.pseudo, g.game_title 
        FROM commentary c
        JOIN users u ON c.user_id = u.user_id
        JOIN games g ON c.game_id = g.game_id
        WHERE c.game_id = :game_id
        ORDER BY c.commentary_id DESC
    ");
    
    // Lier l'id du jeu à la requête
    $query->bindValue(':game_id', $game_id, PDO::PARAM_INT);

    // Exécution de la requête
    $query->execute();

    // Récupérer les derniers commentaires avec les pseudos et le titre du jeu
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si des commentaires existent
    if (count($comments) > 0) {
        // Si des commentaires sont trouvés, récupérer le titre du jeu depuis le premier commentaire
        $game_title = $comments[0]['game_title'];
    } else {
        // Si aucun commentaire n'est trouvé, utiliser un titre par défaut
        $game_title = "Inconnu";
    }

} catch (PDOException $e) {
    // Gestion des erreurs
    echo 'Erreur lors de la récupération des commentaires : ' . $e->getMessage();
}

?>

<?php include "./template/navbar.php" ?>

<main>
    <!-- Affichage dynamique du titre du jeu -->
    <h1 class="h1-infogamecommentaire">Voici tous les commentaires pour <?php echo htmlspecialchars($game_title); ?>
    </h1>
    <a class="infogame-commentaire-btn-retour" href="#" onclick="history.go(-1)">Retour</a>
    <div class="container-commentaire">
        <?php foreach ($comments as $comment) { ?>
        <div class="commentaire">
            <p class="pseudo"><?php echo htmlspecialchars($comment['pseudo']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
        </div>
        <?php } ?>
    </div>

</main>

<?php include "./template/footer.php" ?>