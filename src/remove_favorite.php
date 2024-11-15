<?php
session_start();
require("./connect.php");

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION["user_gamer"]["user_id"])) {
    echo "utilisateur non connecté"; // Indique que l'utilisateur doit être connecté
    exit;
}

// Vérifiez la présence de game_id dans les données POST
if (!isset($_POST['game_id'])) {
    echo "Game ID manquant"; // Indique qu'aucun ID de jeu n'a été reçu
    exit;
}

// Récupère l'ID de l'utilisateur et du jeu à supprimer
$game_id = (int)$_POST['game_id'];
$user_id = (int)$_SESSION["user_gamer"]["user_id"];

// Supprime le jeu des favoris de cet utilisateur
$deleteSql = "DELETE FROM favoris WHERE user_id = :user_id AND game_id = :game_id";
$deleteStmt = $db->prepare($deleteSql);
$deleteStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$deleteStmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
$deleteStmt->execute();