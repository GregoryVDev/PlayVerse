<?php

session_start();

require_once("connect.php");

$sql = "SELECT * FROM games ORDER BY game_id DESC";
$query = $db->prepare($sql);

$query->execute();

$games = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<?php include "./template/navbar.php" ?>
<main>

    <div class="games-container-title">
        <h1 class="games-h1-games">Voici notre sélection de jeux</h1>
        <div class="games-container-plateforme">
            <img class="games-icon-plateforme" src="../img/logos/icon_pc.png" alt="icon pc">
            <img class="games-icon-plateforme" src="../img/logos/icon_playstation.png" alt="icon playstation">
            <img class="games-icon-plateforme" src="../img/logos/icon_xbox.png" alt="icon xbox">
            <img class="games-icon-plateforme" src="../img/logos/icon_switch.png" alt="icon switch">
        </div>
    </div>

    <div class="games-jeu-container">

        <!-- First game card -->
        <?php foreach ($games as $game) {?>
        <article class="games-card-game">
            <?php
                    // Vérifie si l'utilisateur est connecté en vérifiant la présence de 'user_id' dans la session
                    if (isset($_SESSION['user_gamer']['user_id'])) {
                        // Récupère l'ID de l'utilisateur depuis la session
                        $user_id = $_SESSION['user_gamer']['user_id'];
                        // Récupère l'ID du jeu actuel
                        $game_id = $game['game_id'];

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

            <a href="infogame.php?id=<?= $game["game_id"] ?>">
                <img class="games-card-img" src="./admin/<?= $game['jacket'] ?>" alt="<?= $game["game_title"] ?>" />
            </a>
            <div class="games-card-body">
                <h3 class="games-card-title"><?= $game["game_title"] ?></h3>
                <?php
                    // Vérifie si l'utilisateur est connecté en vérifiant la présence de 'user_id' dans la session
                    if (isset($_SESSION['user_gamer']['user_id'])) {
                        // Récupère l'ID de l'utilisateur depuis la session
                        $user_id = $_SESSION['user_gamer']['user_id'];
                        // Récupère l'ID du jeu actuel
                        $game_id = $game['game_id'];

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
                <a class="games-card-btn" href="infogame.php?game_id=<?= $game["game_id"] ?>">Voir</a>
            </div>
        </article>
        <?php } ?>
    </div>

</main>
<script src="/js/favoris.js"></script>
<?php include "./template/footer.php" ?>