<?php
session_start();

require_once("./connect.php");


$sql = $db->prepare("SELECT * FROM reviews ORDER BY review_id DESC");

$sql->execute();

$reviews = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include "./template/navbar.php" ?>
<main>
    <section class="review-section">
        <h1>Les dernières reviews</h1>
        <div class="container-reviews">
            <?php foreach ($reviews as $review) { ?>

                <article class="review">
                    <a href="./review.php?id=<?= $review["review_id"] ?>">
                        <figure>
                            <img src="./img/images/<?= $review["image1"] ?>" alt="<?= $review["review_title"] ?>">
                            <figcaption>
                                <h2><?= $review["review_title"] ?></h2>
                                <p><?= substr($review["paragraph1"], 0, 250) . "..."; ?></p>
                            </figcaption>
                        </figure>
                    </a>
                </article>

            <?php } ?>
            <!-- <article class="review">
                <figure>
                    <img src="./img/images/bmw.png" alt="Black Myth Wukong">
                    <figcaption>
                        <h2>Black Myth Wukong</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime aperiam rerum, tenetur enim eum ullam ratione hic esse placeat rem est modi quos atque veniam! Nulla illo culpa mollitia omnis.</p>
                    </figcaption>
                </figure>
            </article>
            <article class="review">
                <figure>
                    <img src="./img/images/frostpunk.png" alt="Frostpunk">
                    <figcaption>
                        <h2>Frostpunk 2</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime aperiam rerum, tenetur enim eum ullam ratione hic esse placeat rem est modi quos atque veniam! Nulla illo culpa mollitia omnis.</p>
                    </figcaption>
                </figure>
            </article>
            <article class="review">
                <figure>
                    <img src="./img/images/sims.png" alt="Les sims">
                    <figcaption>
                        <h2>Les Sims 4</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime aperiam rerum, tenetur enim eum ullam ratione hic esse placeat rem est modi quos atque veniam! Nulla illo culpa mollitia omnis.</p>
                    </figcaption>
                </figure>
            </article> -->
        </div>
    </section>
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
</main>
<?php include "./template/footer.php" ?>