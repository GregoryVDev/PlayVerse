<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./template/navbar.css">
    <link rel="stylesheet" href="./template/footer.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/favoris.css">
    <link rel="stylesheet" href="./css/reviews.css">
    <link rel="stylesheet" href="./css/games.css">
    <link rel="stylesheet" href="./css/index.css">
    <title>PlayVerse</title>
</head>

<body>



    <?php if (isset($_SESSION["user_gamer"]) && $_SESSION["user_gamer"] == true) { ?>

        <header>
            <div class="container-left">
                <div class="logo">
                    <img src="../img/logos/playverse.png" alt="Logo">
                </div>
                <div class="container-search">
                    <img src="../img/logos/search.svg" alt="Search">
                    <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
                </div>
            </div>
            <div id="burger-menu">
                <span></span>
            </div>
            <nav id="nav">
                <ul class="nav_list">
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="../games.php">Jeux</a></li>
                    <li><a href="../reviews.php">Reviews</a></li>
                    <li class="dropdown">
                        <a href="#" onclick="toggleDropdown()">Mon compte</a>
                        <div class="dropdown-content">
                            <a href="favoris.php">Mes favoris</a>
                            <a href="deconnect.php">Se déconnecter</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>
    <?php } else { ?>

        <header>
            <div class="container-left">
                <div class="logo">
                    <img src="../img/logos/playverse.png" alt="Logo">
                </div>
                <div class="container-search">
                    <img src="../img/logos/search.svg" alt="Search">
                    <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
                </div>
            </div>
            <div id="burger-menu">
                <span></span>
            </div>
            <nav id="nav">
                <ul class="nav_list">
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="../games.php">Jeux</a></li>
                    <li><a href="../reviews.php">Reviews</a></li>
                    <li><a href="../connexion.php" class="button-connect">Connexion</a></li>
                    <li><a href="../inscription.php" class="button-inscri">Inscription</a></li>
                </ul>
                <div class="container-buttons">
                    <a href="../connexion.php" class="button-connection">Connexion</a>
                    <a href="../inscription.php" class="button-inscription">Inscription</a>
                </div>
            </nav>
        </header>
    <?php } ?>