<?php
session_start();
require_once("../connect.php");

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION["admin_gamer"])) {
    // Rediriger vers la page de connexion si l'administrateur n'est pas connecté
    header("Location: ../index.php");
    exit();
}

// Récupérer les données de l'administrateur actuel
$admin_id = $_SESSION["admin_gamer"]["admin_id"];
$sql = "SELECT * FROM admins WHERE admin_id = ?";
$query = $db->prepare($sql);
$query->execute([$admin_id]);
$admin = $query->fetch(PDO::FETCH_ASSOC);
?>

<?php include "./template/navbar.php"; ?>
<main>
    <section class="page">
        <h1>Que voulez-vous modifier ?</h1>

        <div class="container-link-admin-profil">
            <a class="profil-admin-btn" href="edit_pseudo_admin.php?admin_id=<?= $admin['admin_id'] ?>">Modifier le
                pseudo</a>
            <a class="profil-admin-btn" href="edit_email_admin.php?admin_id=<?= $admin['admin_id'] ?>">Modifier
                l'email</a>
            <a class="profil-admin-btn" href="edit_password_admin.php?admin_id=<?= $admin['admin_id'] ?>">Modifier le
                mot de
                passe</a>
        </div>
    </section>
</main>

<script src="./js/admin.js"></script>
</body>

</html>