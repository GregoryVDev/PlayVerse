<?
session_start();

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    require_once("./connect.php");

    $review_id = strip_tags($_GET["id"]);

    $sql = $db->prepare("SELECT * FROM reviews WHERE review_id=:id");

    $sql->bindValue(":id", $review_id, PDO::PARAM_INT);
    $sql->execute();

    $result = $sql->fetch();
}

?>

<?php include "./template/navbar.php" ?>
<main>
    <h1><?= $result["review_title"] ?></h1>
    <section class="image-game">
        <img src="./img/images/<?= $result["image1"] ?>" alt="<?= $result["review_title"] ?>">
    </section>
    <section class="review-article">
        <article class="blog">
            <p><?= $result["paragraph1"] ?>
            </p>
            <img src="./img/images/<?= $result["image2"] ?>" alt="<?= $result["review_title"] ?>">
            <p><?= $result["paragraph2"] ?>
            </p>
            <img src="./img/images/<?= $result["image3"] ?>" alt="<?= $result["review_title"] ?>">
            <p><?= $result["paragraph3"] ?>
            </p>
        </article>
    </section>
    <section class="points">
        <article class="forts">
            <h3>Points forts</h3>
            <p><?= str_replace("\n", "<br/>", $result["high_point"]) ?></p>
        </article>
        <div class="dr"></div>
        <article class="faibles">
            <h3>Points faibles</h3>
            <p>
            <p><?= str_replace("\n", "<br/>", $result["weak_point"]) ?></p>
            </p>
        </article>
    </section>
</main>
<?php include "./template/footer.php" ?>