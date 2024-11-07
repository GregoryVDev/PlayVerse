<?php
session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {

    // Use game_id from the GET request if it exists; otherwise, use default
    $game_id = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 1;

    try {
        // Fetch last three comments with game title and commentary ID for deletion links
        $query = $db->prepare("
            SELECT c.commentary_id, c.message, u.pseudo, g.game_title 
            FROM commentary c
            JOIN users u ON c.user_id = u.user_id
            JOIN games g ON c.game_id = g.game_id
            WHERE c.game_id = :game_id
            ORDER BY c.commentary_id DESC
        ");
        
        $query->bindValue(':game_id', $game_id, PDO::PARAM_INT);
        $query->execute();

        $comments = $query->fetchAll(PDO::FETCH_ASSOC);

        // Set game title from the first comment if comments exist
        $game_title = count($comments) > 0 ? $comments[0]['game_title'] : "Inconnu";

    } catch (PDOException $e) {
        echo 'Erreur lors de la récupération des commentaires : ' . $e->getMessage();
    }

    // Fetch all reviews for the reviews table
    $sql = "SELECT * FROM reviews ORDER BY review_id DESC";
    $query = $db->prepare($sql);
    $query->execute();
    $reviews = $query->fetchAll(PDO::FETCH_ASSOC);

} else {
    header("Location: ../index.php");
    exit;
}
?>

<?php include "./template/navbar.php"; ?>
<main>

    <section class="page">
        <h1>Gestions des commentaires</h1>
    </section>

    <section class="dashboard">
        <h2>Dashboard</h2>

        <div class="container-search">
            <img src="../img/logos/search.svg" alt="Search">
            <input type="search" name="search" id="search" placeholder="Cherchez un jeu...">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Game</th>
                    <th>Pseudo</th>
                    <th>Commentaire</th>
                    <th><input type="checkbox"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment) { ?>
                <tr data-page="1">
                    <td class="actions">
                        <a class="btn-delete"
                            href="deletecommentary.php?id=<?= $comment["commentary_id"] ?>">Supprimer</a>
                    </td>
                    <td><?= htmlspecialchars($comment["game_title"]) ?></td>
                    <td><?= htmlspecialchars($comment["pseudo"]) ?></td>
                    <td><?= htmlspecialchars($comment["message"]) ?></td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <button class="deleteall">Supprimer tout</button>
    </section>
</main>
<script src="./js/admin.js"></script>
</body>

</html>