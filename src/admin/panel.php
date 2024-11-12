<?php

session_start();

if (!isset($_SESSION["admin_gamer"])) {
    header("Location: connexionadmin.php");
}

?>


<?php include "./template/navbar.php" ?>
<main>
    <section class="page">
        <h1>Heureux de te revoir <span class="red"><?= $_SESSION["admin_gamer"]["pseudo"]; ?></span></h1>
        <img src="./img/crash.gif" alt="Crash">
    </section>
    <section class="panel-image">
        <div class="container-gestions">
            <article class="gestions">
                <figure>
                    <a href="jeux.php">
                        <img src="./img/article.jpg" alt="Gestions des jeux">
                        <figcaption>
                            <h4>Gestions des jeux</h4>
                        </figcaption>
                    </a>
                </figure>
            </article>
            <article class="gestions">
                <figure>
                    <a href="plateformes.php">
                        <img src="./img/console.jpg" alt="Gestions des plateformes">
                        <figcaption>
                            <h4>Gestions des plateformes</h4>
                        </figcaption>
                    </a>
                </figure>
            </article>
            <article class="gestions">
                <figure>
                    <a href="userslist.php">
                        <img src="./img/utilisateurs.jpg" alt="Gestions des utilisateurs">
                        <figcaption>
                            <h4>Gestions des utilisateurs</h4>
                        </figcaption>
                    </a>
                </figure>
            </article>
            <article class="gestions">
                <figure>
                    <a href="adminslist.php">
                        <img src="./img/admin.jpg" alt="Gestions des administrateurs">
                        <figcaption>
                            <h4>Gestions des administrateurs</h4>
                        </figcaption>
                    </a>
                </figure>
            </article>
            <article class="gestions">
                <figure>
                    <a href="addreviews.php">
                        <img src="./img/review.jpg" alt="Gestions des reviews">
                        <figcaption>
                            <h4>Gestions des reviews</h4>
                        </figcaption>
                    </a>
                </figure>
            </article>
            <article class="gestions">
                <figure>
                    <a href="messagerie.php">
                        <img src="./img/messagerie.jpg" alt="Messagerie">
                        <figcaption>
                            <h4>Messagerie</h4>
                        </figcaption>
                    </a>
                </figure>
            </article>
        </div>
    </section>
</main>
</body>

</html>