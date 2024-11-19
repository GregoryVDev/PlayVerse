<?php

if (!isset($db)) {
    require("./connect.php");
}

$countMessage = 0;

$sql = "SELECT * FROM message ORDER BY message_id DESC";

$query = $db->prepare($sql);
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    if ($message["lu"] === "unread") {
        $countMessage++;
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="png" href="../img/logos/favicon.png" />
    <link rel="stylesheet" href="../template/navbar.css">
    <link rel="stylesheet" href="../template/footer.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="./css/favoris.css">
    <link rel="stylesheet" href="../css/reviews.css">
    <link rel="stylesheet" href="../css/games.css">
    <link rel="stylesheet" href="../css/infogame.css">
    <link rel="stylesheet" href="../css/mentions_legales.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/privacy.css">
    <link rel="stylesheet" href="./css/profil.css">

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
                    <form action="" method="GET">
                        <img src="../img/logos/search.svg" alt="Search">
                        <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
                    </form>
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
                        <div class="dropdown-content" style="padding: 0px 10px;">
                            <a href="favoris.php">Mes favoris</a>
                            <a href="editemail.php">Email</a>
                            <a href="editmdp.php">Mot de passe</a>
                            <a href="deconnect.php">Déconnexion</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>
    <?php } elseif (isset($_SESSION["admin_gamer"]) && $_SESSION["admin_gamer"] == true) { ?>
        <header>
            <div class="container-left">
                <div class="logo">
                    <img src="../img/logos/playverse.png" alt="Logo">
                </div>
                <div class="container-search">
                    <form action="" method="GET">
                        <img src="../img/logos/search.svg" alt="Search">
                        <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
                    </form>
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
                        <div class="dropdown-content" style="padding: 0px 10px;">
                            <?php if ($countMessage > 0) { ?>
                                <a href="../admin/panel.php" class="unread-message">Retour panel
                                </a>
                            <?php } else { ?>
                                <a href="../admin/panel.php">Retour panel</a>
                            <?php } ?>
                            <a href="deconnect.php">Déconnexion</a>

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