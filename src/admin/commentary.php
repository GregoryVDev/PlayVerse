<?php
session_start();

require_once("../connect.php");

if (isset($_SESSION["admin_gamer"])) {
    try {
        // Préparation de la requête pour récupérer les commentaires avec les pseudos et les titres de jeu
        $query = $db->prepare("
            SELECT c.commentary_id, c.message, u.pseudo, g.game_title
            FROM commentary c
            JOIN users u ON c.user_id = u.user_id
            JOIN games g ON c.game_id = g.game_id
            ORDER BY c.commentary_id DESC
        ");
        $query->execute();
        $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur lors de la récupération des commentaires : ' . $e->getMessage();
        exit;
    }
} else {
    // Si l'utilisateur n'est pas un admin, rediriger vers la page d'accueil
    header("Location: ../index.php");
    exit;
}
?>

<?php include "./template/navbar.php"; ?>

<main>
    <section class="page">
        <h1>Gestion des commentaires</h1>
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
                    <th>Jeu</th>
                    <th>Pseudo</th>
                    <th>Commentaire</th>
                    <th><input type="checkbox"></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($comments): ?>
                <?php foreach ($comments as $comment): ?>
                <tr data-page="1">
                    <td class="actions">
                        <a class="btn-delete"
                            href="deletecommentary.php?id=<?= htmlspecialchars($comment["commentary_id"]) ?>">Supprimer</a>
                    </td>
                    <td><?= htmlspecialchars($comment["game_title"]) ?></td>
                    <td><?= htmlspecialchars($comment["pseudo"]) ?></td>
                    <td><?= nl2br(htmlspecialchars($comment["message"])) ?></td>
                    <td><label><input type="checkbox"></label></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">Aucun commentaire trouvé.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button class="deleteall">Supprimer tout</button>
    </section>
</main>

<script src="./js/admin.js"></script>
</body>

</html>