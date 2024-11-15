<?php

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: ./connexionadmin.php");
}

if (!isset($db)) {
    require("./../connect.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="./../css/fonts.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./css/panel.css">
    <link rel="stylesheet" href="./css/utilisateurs.css">
    <link rel="stylesheet" href="./css/message.css">
    <link rel="stylesheet" href="./css/gestions.css">
    <title>PlayVerse</title>
</head>

<body>

    <?php if (isset($_SESSION["admin_gamer"]) && $_SESSION["admin_gamer"] == true) { ?>
        <header>
            <nav class="navbar navbar-dark bg-dark fixed-top" style="background: transparent !important">
                <div class="container-fluid" style="justify-content: flex-end; margin-right: 10px;">
                    <?php if ($countMessage > 0) {  ?>
                        <button class="navbar-toggler" style="background-color: var(--colorBackOffice)" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    <?php } else { ?>
                        <button class="navbar-toggler" style="background-color: var(--colorButton)" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    <?php } ?>
                    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel" style="text-transform: uppercase"><?= $_SESSION["admin_gamer"]["pseudo"]; ?></h5>
                            <button type=" button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./../index.php">Voir la page en tant qu'utilisateur</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="panel.php">Panel</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Gestions
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" style="padding-left: 10px">
                                        <li><a class="nav-link" href="jeux.php">Gestions des jeux</a></li>
                                        <li><a class="nav-link" href="plateformes.php">Gestions des plateformes</a></li>
                                        <li><a class="nav-link" href="pegis.php">Gestions des PEGIS</a></li>
                                        <li><a class="nav-link" href="categories.php">Gestions des catégories</a></li>
                                        <li><a class="nav-link" href="addreviews.php">Gestions des reviews</a></li>
                                        <li>
                                        <li><a class="nav-link" href="userslist.php">Gestions des utilisateurs</a></li>
                                        <li><a class="nav-link" href="adminslist.php">Gestions des administrateurs</a></li>
                                        <hr class="dropdown-divider">
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Profil
                                        <?php if ($countMessage > 0) { ?>
                                            <span class="unread-message"> <?= $countMessage; ?></span>
                                        <?php } ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" style="padding-left: 10px">
                                        <li><a class="nav-link" href="adminprofil.php">Modifier son profil</a></li>
                                        <li><a class="nav-link" href="messagerie.php">Messagerie
                                                <style>
                                                    .unread-message {
                                                        color: var(--colorBackOffice);
                                                    }
                                                </style>
                                                <?php if ($countMessage > 0) { ?>
                                                    <span class="unread-message"> <?= $countMessage; ?></span>
                                                <?php } ?>
                                            </a></li>
                                        <li><a class="nav-link" href="./../deconnect.php">Se déconnecter</a></li>
                                        <hr class="dropdown-divider">
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    <?php } ?>