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
                    <figure>
                        <img src="./img/images/<?= htmlspecialchars($review["image1"]); ?>" alt="<?= $review["review_title"] ?>">
                        <figcaption>
                            <a href="./review.php?id=<?= $review["review_id"] ?>">
                                <h2><?= $review["review_title"] ?></h2>
                                <p><?= substr($review["paragraph1"], 0, 250) . "..."; ?></p>
                            </a>
                        </figcaption>
                    </figure>
                </article>
            <?php } ?>
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
<script src="./js/pagination.js"></script>

</html>