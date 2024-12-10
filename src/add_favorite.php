<?php
session_start();
require ("./connect.php");

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION["user_gamer"]["user_id"])) {
    echo "l'utimisateur non connecté"; // Réponse indiquant que l'utilisateur n'est pas connecté
    exit;
}

// Vérifiez la présence de game_id dans les données POST
if (!isset($_POST['game_id'])) {
    echo "Game ID manquant";
    exit;
}

$game_id = (int)$_POST['game_id'];
$user_id = (int)$_SESSION["user_gamer"]["user_id"];

try {
    // Vérifiez si l'entrée existe déjà dans la table favoris
    $checkSql = "SELECT * FROM favoris WHERE user_id = :user_id AND game_id = :game_id";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $checkStmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Si le jeu est déjà en favoris, le supprimer
        $deleteSql = "DELETE FROM favoris WHERE user_id = :user_id AND game_id = :game_id";
        $deleteStmt = $db->prepare($deleteSql);
        $deleteStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $deleteStmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        $deleteStmt->execute();
        echo "removed";
    } else {
        // Sinon, l'ajouter
        $insertSql = "INSERT INTO favoris (user_id, game_id) VALUES (:user_id, :game_id)";
        $insertStmt = $db->prepare($insertSql);
        $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $insertStmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        $insertStmt->execute();
        echo "added";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}