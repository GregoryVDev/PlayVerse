<?php
session_start();
require_once("../connect.php");

// Vérifier si l'administrateur est connecté
if (isset($_SESSION["admin_gamer"])) {
    $admin_id = $_SESSION["admin_gamer"]["admin_id"];

    // Récupérer les données de l'administrateur actuel
    $sql = "SELECT * FROM admins WHERE admin_id = :admin_id";
    $query = $db->prepare($sql);
    $query->bindValue(":admin_id", $admin_id, PDO::PARAM_INT);
    $query->execute();
    $admin = $query->fetch(PDO::FETCH_ASSOC);

    // Si le formulaire est soumis, mettre à jour le pseudo, l'email et le mot de passe
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $pseudo = strip_tags($_POST["pseudo"]);
        $email = strip_tags($_POST["email"]);
        $password = password_hash(strip_tags($_POST["password"]), PASSWORD_DEFAULT); // Hachage du nouveau mot de passe

        // Requête SQL pour mettre à jour uniquement le pseudo, l'email et le mot de passe
        $sql_updateAdmin = "UPDATE admins SET 
                                pseudo = :pseudo, 
                                email = :email, 
                                pass = :password 
                            WHERE admin_id = :admin_id";

        $query = $db->prepare($sql_updateAdmin);
        $query->bindValue(":pseudo", $pseudo);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->bindValue(":admin_id", $admin_id, PDO::PARAM_INT);

        try {
            // Exécuter la mise à jour
            $query->execute();
            // Rediriger après la mise à jour
            header("Location: adminprofil.php"); // Rediriger vers la page de profil ou autre page souhaitée après la mise à jour
            exit();
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }
    }
} else {
    // Rediriger vers la page de connexion si l'administrateur n'est pas connecté
    header("Location: ../index.php");
    exit();
}
?>

<?php include "./template/navbar.php"; ?>
<main>
    <section class="page">
        <h1>Modification du profil</h1>
    </section>

    <section class="formulaire">
        <form class="admin-profil-formulaire" method="POST">
            <div class="admin-container-profil">
                <label class="profil-admin-label" for="pseudo">Pseudo :</label>
                <input type="text" name="pseudo" id="pseudo" value="<?php echo htmlspecialchars($admin['pseudo']); ?>"
                    required>
            </div>
            <div class="admin-container-profil">
                <label class="profil-admin-label" for="email">Email :</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($admin['email']); ?>"
                    required>
            </div>
            <div class="admin-container-profil">
                <label class="profil-admin-label" for="password">Nouveau mot de passe :</label>
                <input type="password" name="password" id="password" placeholder="Nouveau mot de passe" required>
            </div>

            <button class="profil-admin-btn" type="submit" class="send">Mettre à jour</button>
        </form>
    </section>
</main>

<script src="./js/admin.js"></script>
</body>

</html>