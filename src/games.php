<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/games.css">
</head>

<body>
    <main>

        <div class="container-title">
            <h1>Voici notre séléctions de jeux PC</h1>
            <div class="container-plateforme">
                <img class="icon-plateforme" src="../img/logos/icon_pc.png" alt="icon pc">
                <img class="icon-plateforme" src="../img/logos/icon_playstation.png" alt="icon playstation">
                <img class="icon-plateforme" src="../img/logos/icon_xbox.png" alt="icon xbox">
                <img class="icon-plateforme" src="../img/logos/icon_switch.png" alt="icon switch">
            </div>
        </div>


        <div class="jeu-container">
            <!-- garder uniquement une des card et faire un foreach pour en afficher d'autre -->
            <article class="card">
                <a href="">
                    <img class="card-img" src="../img/exemple/hollow_knight.png" alt="hollow knight" />
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>

            <!-- les carte ici peuvent être supprimer -->
            <article class="card">
                <a href="">
                    <img class="card-img" src="../img/exemple/elden_ring.jpg" alt="elden ring">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>
            <article class="card">
                <a href="">
                    <img class="card-img" src="../img/exemple/lol.jpg" alt="league of legend">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>
            <article class="card">
                <a href="">
                    <img class="card-img" src="../img/exemple/overwatch.png" alt="overwatch">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>
            <article class="card">
                <a href="">
                    <img class="card-img" src="../img/exemple/mortal_kombat.png" alt="">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>
            <article class="card">
                <a href="">
                    <img class="card-img" src="../img/exemple/sot.png" alt="sea of thieves">
                </a>
                <div class="card-body">
                    <h3 class="card-title">NAME GAME</h3>
                    <a class="card-btn" href="">Voir</a>
                </div>
            </article>
        </div>
    </main>

    <?php include_once 'template/footer.php';?>
</body>

</html>