<?php
session_start();
require_once("./connect.php");

// Vérifiez que l'utilisateur est bien connecté
if (isset($_SESSION["user_gamer"]["user_id"])) {
    $user_id = $_SESSION["user_gamer"]["user_id"];

    // Requête SQL pour récupérer les informations des jeux favoris de l'utilisateur
    $sql = "SELECT g.* FROM games g
            JOIN favoris f ON g.game_id = f.game_id
            WHERE f.user_id = :user_id";

    // Préparer et exécuter la requête
    $query = $db->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();

    // Récupérer tous les résultats et les stocker dans $games
    $games = $query->fetchAll(PDO::FETCH_ASSOC);

    // Redirige si l'utilisateur n'est pas connecté
} else {
    header("Location: index.php");
    exit;
}
?>

<main>
    <?php include "./template/navbar.php" ?>
    <section class="illustration-favoris"></section>
    <section class="favoris">
        <h1>Mes favoris</h1>
        <div class="container-favoris">

            <?php if (!empty($games)) { ?>
                <?php foreach ($games as $game) { ?>

                    <article class="card">

                        <figure>
                            <a href="./infogame.php?id=<?= htmlspecialchars($game["game_id"]) ?>">
                                <img src="./admin/<?= htmlspecialchars($game["jacket"]) ?>"
                                    alt="<?= htmlspecialchars($game["game_title"]) ?>">
                            </a>
                            <figcaption>
                                <p><?= htmlspecialchars($game["game_title"]) ?></p>
                            </figcaption>
                            <!-- Affiche l'étoile pleine (★) si le jeu est en favoris, sinon affiche l'étoile vide (☆) -->
                            <!-- L'attribut data-game-id est ajouté pour identifier le jeu lors des actions de favori -->
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
                        </figure>

                    </article>

                <?php } ?>
            <?php } else {  ?>
                <p class="no-favoris">Vous n'avez pas de favoris.</p>
            <?php } ?>

        </div>



        <!-- PAGINATION -->
        <div id="pagination" class="container-pages">
            <a id="prevPage" href="#pagination">
                <img src="./img/logos/angles-left.svg" alt="Page précédente">
                Précédente
            </a>
            <span id="pageNumbers"></span>
            <a id="nextPage" href="#pagination">
                Suivante
                <img src="./img/logos/angles-right.svg" alt="Page suivante">
            </a>
        </div>
    </section>
</main>
<script src="./js/pagination.js"></script>
<script src="/js/favoris.js"></script>
<?php include "./template/footer.php" ?>