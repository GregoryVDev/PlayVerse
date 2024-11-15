<?php

session_start();

require_once("./connect.php");

$sql = "SELECT * FROM games";

$query = $db->prepare($sql);
$query->execute();

$games = $query->fetchAll(PDO::FETCH_ASSOC);

$sql_game = "SELECT * FROM games ORDER BY game_id DESC LIMIT 4";
$query_game = $db->prepare($sql_game);
$query_game->execute();
$jeux = $query_game->fetchAll(PDO::FETCH_ASSOC);

// Requête pour récupérer le dernier id mis
$sql_last_review = "SELECT * FROM reviews ORDER BY review_id DESC LIMIT 1";
$query_last = $db->prepare($sql_last_review);
$query_last->execute();
$last_review = $query_last->fetch(PDO::FETCH_ASSOC);


// Requête pour récupérer l'id sans le dernier id, on le limite à 2 pour afficher que 2
$sql_review = "SELECT * FROM reviews WHERE review_id < :last_id ORDER BY review_id DESC LIMIT 2";

$query = $db->prepare($sql_review);
$query->bindValue("last_id", $last_review["review_id"]);

$query->execute();
$reviews = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include "./template/navbar.php" ?>
<main>
    <div class="container-header">
        <h1 class="index-title-h1">Plonge dans l'univers de tes jeux favoris</h1>
        <img src="../img/images/principal.png" alt="regroupement de personnages de jeux vidéo">
    </div>
    <div class="carousel-container">
        <div class="carousel" id="carousel">
            <?php foreach ($games as $game) { ?>
                <div class="card-carrousel">
                    <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                    <a href="./infogame.php?id=<?= $game["game_id"] ?>">
                        <img src="./admin/<?= htmlspecialchars($game['jacket']); ?>" alt="<?= $game["game_title"] ?>">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <div>
        <h2 class="index-title-h2">Jeux du moment</h2>

        <!-- a remplacer par les 4 dernier jeux ajouter -->
        <div class="container-jeux-du-moment">
            <?php foreach ($jeux as $jeu) { ?>
                <div class="jeux-du-moment-hover">
                    <a class="jeux-du-moment-lien" href="infogame.php?game_id=<?= $jeu["game_id"] ?>">
                        <img src="../admin/<?= $jeu["image1"] ?>" alt="<?= $jeu["game_title"] ?>" />
                    </a>
                </div>
            <?php } ?>
        </div>



    </div>


    <section class="index-bg-color">
        <div class="parti-2">
            <h3 class="index-title-h3">Rejoins les légendes du jeu vidéo et vis l'aventure ultime</h3>
            <!-- <img src="../img/images/secondary.png" alt="regroupement de personnages de jeux vidéo"> -->
            <img src="../img/images/group3.png" alt="regroupement de personnages de jeux vidéo">
        </div>

        <div>
            <div class="container-title-review">
                <h4 class="index-title-h4">Nos dernières reviews</h4>
                <a class="btn-review" href="reviews.php">Toutes les reviews</a>
            </div>
            <div class="reviews-container-review-index">
                <!-- Large Review -->
                <?php if ($last_review) { ?>
                    <div class="large-review">
                        <img src="../<?= $last_review['image1'] ?>"
                            alt="<?= $last_review["review_title"] ?>">
                        <div class="content">
                            <h3><?= $last_review["review_title"] ?></h3>
                            <a href="review.php?id=<?= $last_review["review_id"] ?>" class="button-review-index">Voir</a>
                        </div>
                    </div>
                <?php } ?>

                <!-- Small Reviews -->
                <div class="small-reviews">
                    <?php foreach ($reviews as $review) { ?>
                        <div class="small-review">
                            <img src="../<?= $review['image1'] ?>" alt="<?= $review["review_title"] ?>">
                            <div class="content">
                                <h3><?= $review["review_title"] ?></h3>
                                <a href="review.php?id=<?= $review["review_id"] ?>" class="button-review-index">Voir</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <section class="index-bg-color">
        <div class="form-contact">
            <h5 class="index-title-h5">Nous envoyer un message</h5>


            <form class="index-form-container" action="./admin/traitement_contact.php" method="POST">
                <!-- Nom et Prénom -->
                <div class="input-group">
                    <div class="input-wrapper">
                        <img src="../img/images/nom.png" alt="Icon Nom">
                        <input placeholder="Nom" type="text" id="nom" name="name" required>
                    </div>
                    <div class="input-wrapper">
                        <img src="../img/images/prenom.png" alt="Icon Prénom">
                        <input placeholder="Prénom" type="text" id="prenom" name="firstname" required>
                    </div>
                </div>

                <!-- Objet et E-mail -->
                <div class="input-group">
                    <div class="input-wrapper">
                        <img src="../img/images/objet.png" alt="Icon Objet">
                        <input placeholder="Objet" type="text" id="objet" name="object" required>
                    </div>
                    <div class="input-wrapper">
                        <img src="../img/images/email.png" alt="Icon Email">
                        <input placeholder="E-mail" type="email" id="email" name="email" required>
                    </div>
                </div>

                <!-- Message : occupe toute la largeur -->
                <div class="full-width">
                    <img src="../img/images/message.png" alt="Icon Message">
                    <textarea placeholder="Message" id="message" name="message" rows="5" required></textarea>
                </div>

                <input type="submit" value="Envoyer">
            </form>
        </div>

        <h6 class="index-title-h6">Abonnez-vous à notre newsletter</h6>
        <form class="newsletter" action="#" method="post">

            <input type="email" id="email" name="email" placeholder="Votre email" required>

            <button class="newsletter-btn" type="submit">S'abonner</button>
        </form>

    </section>
</main>
<?php include "./template/footer.php" ?>
<script src="../js/carrousel.js"></script>
<script src="../js/form_contact.js"></script>