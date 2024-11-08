<?php

session_start();

?>

<?php include "./template/navbar.php" ?>
<main>
    <div class="container-header">
        <h1 class="index-title-h1">Plonge dans l'univers de tes jeux favoris</h1>
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
        <h2 class="index-title-h2">Jeux du moment</h2>

        <!-- a remplacer par les 4 dernier jeux ajouter -->
        <div class="container-jeux-du-moment">
            <div class="jeux-du-moment-hover">
                <a class="jeux-du-moment-lien" href="#">
                    <img src="../img/exemple/bmw.png" alt="exemple1" />
                </a>
            </div>
            <div class="jeux-du-moment-hover">
                <a class="jeux-du-moment-lien" href="#">
                    <img src="../img/exemple/frostpunk.png" alt="exemple2" />
                </a>
            </div>
            <div class="jeux-du-moment-hover">
                <a class="jeux-du-moment-lien" href="#">
                    <img src="../img/exemple/sims.png" alt="exemple3" />
                </a>
            </div>
            <div class="jeux-du-moment-hover">
                <a class="jeux-du-moment-lien" href="#">
                    <img src="../img/exemple/zelda.png" alt="exemple4" />
                </a>
            </div>
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
                <div class="large-review">
                    <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/1601580/ss_584751cfb3cc04ef4da075382e879f448d7bfedc.1920x1080.jpg?t=1689763082"
                        alt="Frostpunk 2">
                    <div class="content">
                        <h3>Black Myth Wukong</h3>
                        <a href="" class="button-review-index">Voir</a>
                    </div>
                </div>
                <!-- Small Reviews -->
                <div class="small-reviews">
                    <div class="small-review">
                        <img src="https://cdn.akamai.steamstatic.com/steam/apps/2358720/capsule_616x353.jpg?t=1710421488"
                            alt="Black Myth Wukong">
                        <div class="content">
                            <h3>Black Myth Wukong</h3>
                            <a href="" class="button-review-index">Voir</a>
                        </div>
                    </div>
                    <div class="small-review">
                        <img src="https://image.api.playstation.com/vulcan/img/rnd/202111/3019/Btg9YJMDRcWgsbD5E6rOcdT5.jpg"
                            alt="The Sims 4">
                        <div class="content">
                            <h3>The Sims 4</h3>
                            <a href="" class="button-review-index">Voir</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>


    <section class="index-bg-color">
        <div class="form-contact">
            <h5 class="index-title-h5">Nous envoyer un message</h5>


            <form class="index-form-container" action="#" method="post">
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

</html>