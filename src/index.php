<?php

session_start();

?>

<?php include "./template/navbar.php" ?>
<main>
    <div class="container-header">
        <h1 class="title-h1">Plonge dans l'univers de tes jeux favoris</h1>
        <img src="../img/images/principal.png" alt="regroupement de personnages de jeux vidéo">
    </div>
    <div class="carousel-container">
        <div class="carousel" id="carousel">
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/elden_ring.jpg" alt="elden ring">
                </a>
            </div>
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/halo.jpg" alt="halo">
                </a>
            </div>
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/hollow_knight.png" alt="hollow knight">
                </a>
            </div>
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/lol.jpg" alt="league of legend">
                </a>
            </div>
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/overwatch.png" alt="overwatch">
                </a>
            </div>
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/mortal_kombat.png" alt="">
                </a>
            </div>
            <div class="card-carrousel">
                <span class="favorite" onclick="toggleFavorite(this)">☆</span>
                <a href="">
                    <img src="../img/exemple/sot.png" alt="sea of thieves">
                </a>
            </div>
        </div>
    </div>

    <div>
        <h2 class="title-h2">Jeux du moment</h2>

        <!-- a remplacer par les 4 dernier jeux ajouter -->
        <div class="container-jeux-du-moment">
            <a class="jeux-du-moment-lien" href="#">
                <img src="../img/exemple/bmw.png" alt="exemple1">
            </a>
            <a class="jeux-du-moment-lien" href="#">
                <img src="../img/exemple/frostpunk.png" alt="exemple2">
            </a>
            <a class="jeux-du-moment-lien" href="#">
                <img src="../img/exemple/sims.png" alt="exemple3">
            </a>
            <a class="jeux-du-moment-lien" href="#">
                <img src="../img/exemple/zelda.png" alt="exemple4">
            </a>
        </div>


    </div>


    <section>
        <div class="parti-2">
            <h3 class="title-h3">Rejoins les légendes du jeu vidéo et vis l'aventure ultime</h3>
            <!-- <img src="../img/images/secondary.png" alt="regroupement de personnages de jeux vidéo"> -->
            <img src="../img/images/group3.png" alt="regroupement de personnages de jeux vidéo">
        </div>

        <div class="container-title-review">
            <h4 class="title-h4">Nos dernières reviews</h4>
            <a class="btn-review" href="">Toutes les reviews</a>
        </div>

        <div class="container-game-review">
            <img class="review-img" src="../img/exemple/bmw2.jpg" alt="game background 1" class="image-large">
            <div class="right-images">
                <img class="image-small review-img" src="../img/exemple/bmw2.jpg" alt="game background 2">
                <img class="image-small review-img" src="../img/exemple/bmw2.jpg" alt="game background 3">
            </div>
        </div>

    </section>


    <section>
        <div class="form-contact">
            <h5 class="title-h5">Nous envoyer un message</h5>


            <form class="form-container" action="#" method="post">
                <!-- Nom et Prénom -->
                <div class="input-group">
                    <div class="input-wrapper">
                        <img src="../img/images/nom.png" alt="Icon Nom">
                        <input placeholder="Nom" type="text" id="nom" name="nom" required>
                    </div>
                    <div class="input-wrapper">
                        <img src="../img/images/prenom.png" alt="Icon Prénom">
                        <input placeholder="Prénom" type="text" id="prenom" name="prenom" required>
                    </div>
                </div>

                <!-- Objet et E-mail -->
                <div class="input-group">
                    <div class="input-wrapper">
                        <img src="../img/images/objet.png" alt="Icon Objet">
                        <input placeholder="Objet" type="text" id="objet" name="objet" required>
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

        <div>
            <h6 class="title-h6">Abonnez-vous à notre newsletter</h6>
            <form class="newsletter" action="#" method="post">

                <input type="email" id="email" name="email" placeholder="Votre email" required>

                <button type="submit">S'abonner</button>
            </form>
        </div>

    </section>
</main>
<?php include "./template/footer.php" ?>