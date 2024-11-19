<?php
// Démarre la session pour gérer l'identification de l'utilisateur
session_start();

// Inclut le fichier de connexion à la base de données
require_once("connect.php");

// Vérifie si l'ID du jeu existe dans les paramètres GET et le convertit en entier
$game_id = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 0;

// Vérifie si l'ID du jeu est valide
if ($game_id <= 0) {
    // Redirige vers index.php si l'ID du jeu est invalide ou absent
    header("Location: games.php");
    exit();
}
// Vérifie si l'utilisateur est connecté
if (isset($_SESSION["user_gamer"])) {
    // Si l'utilisateur est connecté, récupère son ID
    $user_id = $_SESSION["user_gamer"]["user_id"];

    // Vérifie si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Nettoie le commentaire soumis par l'utilisateur (enlève les espaces superflus)
        $commentaire = trim($_POST["commentaire"]);

        // Vérifie que le commentaire n'est pas vide
        if (!empty($commentaire)) {
            try {
                // Prépare la requête SQL pour insérer le commentaire dans la base de données
                $query = $db->prepare("INSERT INTO commentary (user_id, game_id, message) VALUES (:user_id, :game_id, :message)");

                // Lie les paramètres à la requête pour prévenir des injections SQL
                $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $query->bindValue(':game_id', $game_id, PDO::PARAM_INT);
                $query->bindValue(':message', htmlspecialchars($commentaire), PDO::PARAM_STR); // Sécurise le commentaire contre les attaques XSS

                // Exécute la requête d'insertion et vérifie si elle a réussi
                if ($query->execute()) {
                    set_flash_message('success', 'Commentaire ajouté avec succès !');
                } else {
                    set_flash_message('error', 'Erreur lors de l\'ajout du commentaire.');
                }
            } catch (PDOException $e) {
                // En cas d'erreur, affiche un message d'erreur avec les détails
                set_flash_message('error', 'Erreur lors de l\'ajout du commentaire : ' . $e->getMessage());
            }
        } else {
            // Si le commentaire est vide, affiche un message d'erreur
            set_flash_message('error', 'Le commentaire ne peut pas être vide.');
        }

        // Redirige vers la même page pour rafraîchir l'affichage des commentaires
        header("Location: " . $_SERVER['PHP_SELF'] . "?game_id=" . $game_id);
        exit();
    }
} else {
    // Si l'utilisateur n'est pas connecté, l'ID utilisateur est défini à null
    $user_id = null;
}

// Fonction pour afficher un message flash (succès ou erreur)
function set_flash_message($type, $message)
{
    $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
}

try {
    // Requête pour récupérer les informations du jeu, incluant les catégories et PEGI
    $game_info = $db->prepare("
    SELECT 
        g.game_id, 
        g.game_title, 
        g.admin_id, 
        g.pegi_id, 
        g.category_id, 
        g.jacket, 
        g.content, 
        g.background, 
        g.trailer, 
        g.image1, 
        g.image2, 
        g.image3, 
        g.image4,
        p.pegi_name, 
        p.pegi_icon,
        c.category_name
    FROM 
        games g
    INNER JOIN 
        pegi p ON g.pegi_id = p.pegi_id
    INNER JOIN 
        category c ON g.category_id = c.category_id
    WHERE 
        g.game_id = :game_id
    ");
    // Liaison de l'ID du jeu
    $game_info->bindValue(':game_id', $game_id, PDO::PARAM_INT);
    $game_info->execute();

    // Si aucun jeu n'est trouvé, redirige vers index.php
    if ($game_info->rowCount() == 0) {
        header("Location: games.php");
        exit();
    }
    $game_data = $game_info->fetch(PDO::FETCH_ASSOC);

    // Requête pour récupérer les plateformes associées au jeu
    $query_platforms = $db->prepare("
        SELECT 
            pf.plateforme_name, 
            pf.plateforme_icon
        FROM 
            gamesplateformes gp
        INNER JOIN 
            plateformes pf ON gp.plateforme_id = pf.plateforme_id
        WHERE 
            gp.game_id = :game_id
    ");
    // Liaison de l'ID du jeu pour la requête des plateformes
    $query_platforms->bindValue(':game_id', $game_id, PDO::PARAM_INT);
    $query_platforms->execute();
    $platforms = $query_platforms->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour les 3 derniers commentaires
    $query_comments = $db->prepare("
        SELECT c.message, u.pseudo 
        FROM commentary c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.game_id = :game_id
        ORDER BY c.commentary_id DESC
        LIMIT 3
    ");
    $query_comments->bindValue(':game_id', $game_id, PDO::PARAM_INT);
    $query_comments->execute();
    $comments = $query_comments->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour les 3 derniers jeux ajoutés, excluant le jeu actuel
    $query_last_games = $db->prepare("
        SELECT game_id, game_title, jacket
        FROM games
        WHERE game_id != :game_id
        ORDER BY game_id DESC
        LIMIT 3
    ");
    $query_last_games->bindValue(':game_id', $game_id, PDO::PARAM_INT);
    $query_last_games->execute();
    $last_games_info = $query_last_games->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gestion des erreurs SQL
    echo 'Erreur lors de la récupération des informations : ' . $e->getMessage();
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

    <!-- Background header (desktop version) -->
    <div class="infogame-container-header">
        <img class="bg-game" src="./admin/<?php echo htmlspecialchars($game_data['background']); ?>"
            alt="<?php echo htmlspecialchars($game_data['game_title']); ?>">
        <img class="infogame-header-pegi" src="./admin/<?php echo htmlspecialchars($game_data['pegi_icon']); ?>"
            alt="<?php echo htmlspecialchars($game_data['pegi_name']); ?>">
    </div>

    <!-- Main game -->
    <article class="container-game">
        <div class="mobile-main">
            <img class="game-img" src="./admin/<?php echo htmlspecialchars($game_data['image1']); ?>"
                alt="<?php echo htmlspecialchars($game_data['game_title']); ?>">
            <img class="infogame-pegi" src="./admin/<?php echo htmlspecialchars($game_data['pegi_icon']); ?>"
                alt="<?php echo htmlspecialchars($game_data['pegi_name']); ?>">
        </div>

        <!-- Game info -->
        <div class="game-info">
            <h1 class="game-name"><?php echo htmlspecialchars($game_data['game_title']); ?></h1>
            <p class="game-description"><?php echo htmlspecialchars($game_data['content']); ?></p>

            <!-- Type game -->
            <div class="container-game-type">
                <span><?php echo htmlspecialchars($game_data['category_name']); ?></span>
            </div>
        </div>
    </article>

    <!-- Ajouter favoris -->
    <?php
    // Vérifie si l'utilisateur est connecté en vérifiant la présence de 'user_id' dans la session
    if (isset($_SESSION['user_gamer']['user_id'])) {
        // Récupère l'ID de l'utilisateur depuis la session
        $user_id = $_SESSION['user_gamer']['user_id'];
        // Récupère l'ID du jeu actuel
        $game_id = (int)$_GET['game_id'];

        // Prépare une requête SQL pour vérifier si le jeu est déjà dans les favoris de l'utilisateur
        $checkFavoriteSql = "SELECT * FROM favoris WHERE user_id = :user_id AND game_id = :game_id";
        $checkFavoriteStmt = $db->prepare($checkFavoriteSql);
        // Lie les paramètres de la requête pour sécuriser les données
        $checkFavoriteStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $checkFavoriteStmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        // Exécute la requête-
        $checkFavoriteStmt->execute();
        // Vérifie si une ligne est retournée, ce qui signifie que le jeu est déjà en favori
        $isFavorite = $checkFavoriteStmt->fetchColumn() !== false;
    ?>
    <!-- Affiche une étoile remplie si le jeu est en favori, sinon une étoile vide -->
    <span class="favorite <?= $isFavorite ? 'filled' : '' ?>" data-game-id="<?= $game_id ?>"
        onclick="toggleFavorite(this, <?= $game_id ?>)">
        <?= $isFavorite ? '★' : '☆' ?>
    </span>
    <?php } else { ?>
    <!-- Si l'utilisateur n'est pas connecté, affiche une étoile vide désactivée -->
    <span class="favorite disabled" onclick="alertNotLoggedIn()">
        ☆
    </span>
    <?php } ?>

    <!-- Plateforme game -->
    <div class="container-game-plateforme">
        <h2 class="infogame-h2">Disponible sur</h2>
        <div class="container-plateforme">

            <?php foreach ($platforms as $platform): ?>
            <img class="icon-plateforme" src="./admin/<?php echo htmlspecialchars($platform['plateforme_icon']); ?>"
                alt="<?php echo htmlspecialchars($platform['plateforme_name']); ?>">
            <?php endforeach; ?>

        </div>
    </div>

    <!-- Trailer game -->
    <div class="iframe-container">
        <iframe src="<?= $game_data["trailer"] ?>" allowfullscreen></iframe>
    </div>

    <!-- 3 picture of game -->
    <div class="container-infogame-img">
        <!-- Large img -->
        <div class="large-img-infogame">
            <img src="./admin/<?php echo htmlspecialchars($game_data['image2']); ?>"
                alt="<?php echo htmlspecialchars($game_data['game_title']); ?>" />
        </div>
        <!-- Small img -->
        <div class="small-imgs-infogame">
            <div class="small-img-infogame">
                <img src="./admin/<?php echo htmlspecialchars($game_data['image3']); ?>"
                    alt="<?php echo htmlspecialchars($game_data['game_title']); ?>" />
            </div>
            <div class="small-img-infogame">
                <img src="./admin/<?php echo htmlspecialchars($game_data['image4']); ?>"
                    alt="<?php echo htmlspecialchars($game_data['game_title']); ?>" />
            </div>
        </div>
    </div>
    <div class="infogame-vague">
    </div>
    <section class="infogame-bg-color">
        <!-- Commentaires (max 3) -->
        <h3 class="infogame-h3">Voici leurs avis</h3>
        <div class="container-commentaire">
            <?php foreach ($comments as $comment): ?>
            <div class="commentaire">
                <p class="pseudo"><?php echo htmlspecialchars($comment['pseudo']); ?></p>
                <p class="message"><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
            </div>
            <?php endforeach; ?>
            <a class="more-commentary-btn" href="infogamecommentaire.php?game_id=<?= $game_data["game_id"] ?>">Voir tous
                les commentaires</a>
        </div>

        <div>
            <?php if (isset($_SESSION["user_gamer"])): ?>
            <!-- Section pour laisser un commentaire si l'utilisateur est connecté -->
            <h4 class="infogame-h4">Laissez votre commentaire</h4>
            <form action="#" method="post" class="form-inline">
                <input class="input-commentaire" type="text" id="commentaire" name="commentaire"
                    placeholder="Tapez votre commentaire ici">
                <input class="btn" type="submit" value="Envoyer">
            </form>
            <?php else: ?>
            <!-- Section de connexion si l'utilisateur n'est pas connecté -->
            <div class="infogame-connexion">
                <h4 class="infogame-h4">Veuillez vous connecter pour laisser un commentaire</h4>
                <a class="info-game-connexion-btn" href="connexion.php">Se connecter</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Derniers jeux ajoutés -->
        <h5 class="infogame-h5">Nos derniers jeux ajoutés</h5>
        <div class="jeu-container">
            <?php foreach ($last_games_info as $last_game): ?>
            <article class="card-game">
                <a href="infogame.php?game_id=<?= $last_game["game_id"] ?>">
                    <img class="card-img" src="./admin/<?php echo htmlspecialchars($last_game['jacket']); ?>"
                        alt="<?php echo htmlspecialchars($last_game['game_title']); ?>" />
                </a>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($last_game['game_title']); ?></h3>
                    <a class="card-btn" href="infogame.php?game_id=<?= $last_game["game_id"] ?>">Voir</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<script src="./js/favoris.js"></script>
<?php include "./template/footer.php" ?>

