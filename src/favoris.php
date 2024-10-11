<? include "./template/navbar.php" ?>
<section class="illustration-favoris"></section>
<section class="favoris">
    <h1>Mes favoris</h1>
    <div class="container-favoris">
        <article class="card" id="pagination">
            <figure>
                <img src="./img/games/halo.jpg" alt="Halo">
                <figcaption>
                    <p>Halo : The Master Chief Collection</p>
                </figcaption>
                <img src="./img/logos/starfull.svg" alt="Favoris" class="star">
            </figure>
        </article>
        <article class="card">
            <figure>
                <img src="./img/games/mk.webp" alt="Mortal Kombat">
                <figcaption>
                    <p>Mortal Kombat 11</p>
                </figcaption>
                <img src="./img/logos/starfull.svg" alt="Favoris" class="star">
            </figure>
        </article>
        <article class="card">
            <figure>
                <img src="./img/games/eldenring.jpg" alt="Elden Ring">
                <figcaption>
                    <p>Elden Ring</p>
                </figcaption>
                <img src="./img/logos/starfull.svg" alt="Favoris" class="star">
            </figure>
        </article>
        <article class="card">
            <figure>
                <img src="./img/games/lol.jpg" alt="League of Legend">
                <figcaption>
                    <p>League of Legend</p>
                </figcaption>
                <img src="./img/logos/starfull.svg" alt="Favoris" class="star">
            </figure>
        </article>
        <article class="card">
            <figure>
                <img src="./img/games/overwatch.png" alt="Overwatch">
                <figcaption>
                    <p>Overwatch</p>
                </figcaption>
                <img src="./img/logos/starfull.svg" alt="Favoris" class="star">
            </figure>
        </article>
    </div>
    <!-- PAGINATION -->
    <div id="pagination" class="container-pages">
        <a id="prevPage" href="#pagination">
            <img src="./img/logos/angles-left.svg" alt="Page précédente">
            Précédente
        </a>
        <span id="pageNumbers"></span>
        <a id="nextPage" href="#pagination">
            Suivante
            <img src="./img/logos/angles-right.svg" alt="Page suivante">
        </a>
    </div>
    <button id="delete">Tout supprimer</button>
</section>
</main>
<? include "./template/footer.php" ?>
</body>
<script src="./js/script.js"></script>

</html>