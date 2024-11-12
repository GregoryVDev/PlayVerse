<?php

session_start();

// Connexion à la base de données
require_once("connect.php");

// Vérifier si l'utilisateur est connecté en vérifiant si "user_gamer" existe dans $_SESSION
if (isset($_SESSION["user_gamer"])) {
    // Récupération de l'identifiant de l'utilisateur connecté
    $user_id = $_SESSION["user_gamer"]["user_id"];
} else {
    // Si l'utilisateur n'est pas connecté, définir $user_id comme null ou un autre comportement
    $user_id = null;
}

// Utiliser game_id depuis la requête GET si elle existe ; sinon, utiliser la valeur 1
$game_id = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 1;


// Fonction pour définir un message flash
function set_flash_message($type, $message) {
    $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère le commentaire depuis le formulaire et sécurise son contenu
    $commentaire = trim($_POST["commentaire"]);

    // Vérifie que le commentaire n'est pas vide
    if (!empty($commentaire)) {
        try {
            // Préparation de la requête SQL pour insérer le commentaire
            $query = $db->prepare("INSERT INTO commentary (user_id, game_id, message) VALUES (:user_id, :game_id, :message)");

            // Lie les valeurs aux paramètres de la requête
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $query->bindValue(':game_id', $game_id, PDO::PARAM_INT);
            $query->bindValue(':message', htmlspecialchars($commentaire), PDO::PARAM_STR); // Sécurisation XSS

            // Exécute la requête
            if ($query->execute()) {
                set_flash_message('success', 'Commentaire ajouté avec succès !');
            } else {
                set_flash_message('error', 'Erreur lors de l\'ajout du commentaire.');
            }
        } catch (PDOException $e) {
            // Gestion des erreurs de base de données
            set_flash_message('error', 'Erreur lors de l\'ajout du commentaire : ' . $e->getMessage());
        }
    } else {
        set_flash_message('error', 'Le commentaire ne peut pas être vide.');
    }

    // Redirection vers la même page pour afficher le message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Récupération des 3 derniers commentaires et pseudos
try {

    // Préparation de la requête SQL avec une jointure entre commentary et users, et une limitation à 3 commentaires
    $query = $db->prepare("
        SELECT c.message, u.pseudo 
        FROM commentary c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.game_id = :game_id
        ORDER BY c.commentary_id DESC
        LIMIT 3
    ");

    // Lier l'id du jeu à la requête
    $query->bindValue(':game_id', $game_id, PDO::PARAM_INT);

    // Exécution de la requête
    $query->execute();

    // Récupérer les 3 derniers commentaires avec les pseudos
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Gestion des erreurs
    echo 'Erreur lors de la récupération des commentaires : ' . $e->getMessage();
}

?>





<?php include "./template/navbar.php" ?>

<main class="infogame">

    <!-- Ajouter des messages de succès ou d'erreur -->
    <?php if (isset($_SESSION['flash_message'])): ?>
    <div
        class="alert <?php echo $_SESSION['flash_message']['type'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
        <?php echo $_SESSION['flash_message']['message']; ?>
    </div>
    <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <!-- background header (desktop version) -->
    <div class="infogame-container-header">
        <img class="bg-game" src="../img/exemple/bmw.png" alt="game background">
        <img class="infogame-header-pegi" src="../img/logos/pegi_16.png" alt="icon pegi">
    </div>

    <!-- main game -->
    <article class="container-game">
        <div class="mobile-main">
            <img class="game-img" src="../img/exemple/bmw2.jpg" alt="game background">
            <img class="infogame-pegi" src="../img/logos/pegi_16.png" alt="icon pegi">
        </div>

        <!-- game info -->
        <div class="game-info">
            <h1 class="game-name">Name of the game</h1>
            <p class="game-description">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam molestiae
                fugiat quis aspernatur
                alias qui autem vel reprehenderit, temporibus, nostrum, esse voluptates? Quia nemo, dignissimos
                possimus delectus assumenda corrupti reprehenderit?</p>

            <!-- type game  -->
            <div class="container-game-type">
                <span>Action</span>
            </div>

        </div>
    </article>

    <!-- ajouter favoris -->
    <span class="favorite" onclick="toggleFavorite(this)">☆</span>

    <!-- plateforme game -->
    <div class="container-game-plateforme">
        <h2 class="infogame-h2">Disponible sur</h2>
        <div class="container-plateforme">
            <img class="icon-plateforme" src="../img/logos/icon_pc.png" alt="icon pc">
            <img class="icon-plateforme" src="../img/logos/icon_playstation.png" alt="icon playstation">
            <img class="icon-plateforme" src="../img/logos/icon_xbox.png" alt="icon xbox">
            <img class="icon-plateforme" src="../img/logos/icon_switch.png" alt="icon switch">
        </div>
    </div>

    <!-- trailler game -->
    <div class="iframe-container">
        <iframe src="https://www.youtube.com/embed/6NWj-EWlguc?si=aGMYK_tnFe0rXLqF" allowfullscreen></iframe>
    </div>

    <!-- 3 picture of game -->
    <div class="container-picture-game">
        <img src="../img/exemple/bmw2.jpg" alt="game background 1" class="image-large">
        <div class="right-images">
            <img class="image-small" src="../img/exemple/bmw2.jpg" alt="game background 2">
            <img class="image-small" src="../img/exemple/bmw2.jpg" alt="game background 3">
        </div>
    </div>



    <section class="infogame-bg-color">

        <!-- commentaire (max 3) -->
        <h3 class="infogame-h3">Voici leurs avis</h3>
        <div class="container-commentaire">

            <?php foreach ($comments as $comment) { ?>
            <div class="commentaire">
                <p class="pseudo"><?php echo htmlspecialchars($comment['pseudo']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
            </div>
            <?php } ?>
            <a class="more-commentary-btn" href="infogamecommentaire.php">Voir tout les commentaires</a>

        </div>

        <div>

            <?php if (isset($_SESSION["user_gamer"]) && $_SESSION["user_gamer"] == true) { ?>

            <!-- Section pour laisser un commentaire si l'utilisateur est connecté -->
            <h4 class="infogame-h4">Laissez votre avis</h4>
            <form action="#" method="post" class="form-inline">
                <input type="text" id="commentaire" name="commentaire" placeholder="Tapez votre commentaire ici">
                <input class="btn" type="submit" value="Envoyer">
            </form>
            <?php } else { ?>

            <!-- Section de connexion si l'utilisateur n'est pas connecté -->
            <div class="infogame-connexion">
                <h4 class="infogame-h4">Veuillez vous connecter pour laisser un avis</h4>
                <a class="info-game-connexion-btn" href="connexion.php">Se connecter</a>
            </div>
            <?php } ?>
        </div>

        <!-- Derniers jeux ajouter -->
        <h5 class="infogame-h5">Nos derniers jeux ajouter</h5>
        <div class="jeu-container">
            <article class="card-game">
                <img class="gameinfo-star" src="img/logos/star.svg" alt="star logo">
                <a href="">
                    <img class="card-img" src="../img/exemple/hollow_knight.png" alt="hollow knight" />
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <img class="gameinfo-star" src="img/logos/star.svg" alt="star logo">
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

            <article class="card-game">
                <img class="gameinfo-star" src="img/logos/star.svg" alt="star logo">
                <a href="">
                    <img class="card-img" src="../img/exemple/elden_ring.jpg" alt="elden ring">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <img class="gameinfo-star" src="img/logos/star.svg" alt="star logo">
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

            <article class="card-game">
                <img class="gameinfo-star" src="img/logos/star.svg" alt="star logo">
                <a href="">
                    <img class="card-img" src="../img/exemple/lol.jpg" alt="league of legend">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <img class="gameinfo-star" src="img/logos/star.svg" alt="star logo">
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

        </div>
    </section>
</main>
<?php include "./template/footer.php" ?>