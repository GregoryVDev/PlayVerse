<?php include "./template/navbar.php" ?>

<main class="infogame">
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
                <span>Aventure</span>
                <span>RPG</span>
                <span>Solo</span>
            </div>

        </div>
    </article>

    <!-- ajouter favoris -->
    <span class="favorite" onclick="toggleFavorite(this)">☆</span>

    <!-- plateforme game -->
    <div class="container-game-plateforme">
        <h2>Disponible sur</h2>
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

        <!-- commentary (max 3) -->
        <h3>Voici leurs avis</h3>
        <div class="container-commentaire">
            <div class="commentaire">
                <p class="pseudo">Pseudo</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officiis error sed vitae enim placeat
                    beatae
                    sit possimus iure unde esse impedit quidem doloremque cumque neque ullam, labore eaque optio autem!
                </p>
            </div>
            <div class="commentaire">
                <p class="pseudo">Pseudo</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officiis error sed vitae enim placeat
                    beatae
                    sit possimus iure unde esse impedit quidem doloremque cumque neque ullam, labore eaque optio autem!
                </p>
            </div>
            <div class="commentaire">
                <p class="pseudo">Pseudo</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officiis error sed vitae enim placeat
                    beatae
                    sit possimus iure unde esse impedit quidem doloremque cumque neque ullam, labore eaque optio autem!
                </p>
            </div>
        </div>

        <!-- add a new commentary (only vissible if the user is connected) -->
        <div>
            <h4>Laissez votre avis</h4>
            <form action="#" method="post" class="form-inline">
                <input type="text" id="commentaire" name="commentaire" placeholder="Tapez votre commentaire ici">
                <input class="btn" type="submit" value="Envoyer">
            </form>
        </div>

        <!-- last added game -->
        <h5>Nos derniers jeux ajouter</h5>
        <div class="jeu-container">
            <article class="card-game">
                <a href="">
                    <img class="card-img" src="../img/exemple/hollow_knight.png" alt="hollow knight" />
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

            <article class="card-game">
                <a href="">
                    <img class="card-img" src="../img/exemple/elden_ring.jpg" alt="elden ring">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

            <article class="card-game">
                <a href="">
                    <img class="card-img" src="../img/exemple/lol.jpg" alt="league of legend">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

        </div>
    </section>
</main>
<?php include "./template/footer.php" ?>