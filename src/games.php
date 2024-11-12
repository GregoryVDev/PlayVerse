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
        <h1 class="games-h1-games">Voici notre sélection de jeux PC</h1>
        <div class="games-container-plateforme">
            <img class="games-icon-plateforme" src="../img/logos/icon_pc.png" alt="icon pc">
            <img class="games-icon-plateforme" src="../img/logos/icon_playstation.png" alt="icon playstation">
            <img class="games-icon-plateforme" src="../img/logos/icon_xbox.png" alt="icon xbox">
            <img class="games-icon-plateforme" src="../img/logos/icon_switch.png" alt="icon switch">
        </div>
    </div>

    <div class="games-jeu-container">

        <!-- First game card -->
        <?php foreach ($games as $game) { ?>
        <article class="games-card-game">
            <img class="games-star" src="img/logos/star.svg" alt="star logo">
            <a href="infogame.php?id=<?= $game["game_id"] ?>">
                <img class="games-card-img" src="<?= $game['jacket'] ?>" alt="<?= $game["game_title"] ?>" />
            </a>
            <div class="games-card-body">
                <h3 class="games-card-title"><?= $game["game_title"] ?></h3>
                <img class="games-star" src="img/logos/star.svg" alt="star logo">
                <a class="games-card-btn" href="infogame.php?id=<?= $game["game_id"] ?>">Voir</a>
            </div>
        </article>
        <?php } ?>

    </div>

</main>
<?php include "./template/footer.php" ?>