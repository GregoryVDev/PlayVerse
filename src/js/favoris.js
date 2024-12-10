function alertNotLoggedIn() {
    // Affiche une alerte invitant l'utilisateur à se connecter ou s'inscrire
    alert(
        "Veuillez vous connecter ou vous inscrire pour ajouter ce jeu en favori."
    );
}

function toggleFavorite(star, gameId) {
    // Détermine si l'action est un ajout ou un retrait des favoris
    const isAdding = !star.classList.contains("filled");

    // Crée une requête HTTP asynchrone
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./../add_favorite.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Gère la réponse de la requête
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Vérifie la réponse du serveur
            if (xhr.responseText === "added") {
                // Si le jeu a été ajouté aux favoris, met à jour l'apparence de l'étoile
                star.classList.add("filled");
                star.textContent = "★";
            } else if (xhr.responseText === "removed") {
                // Si le jeu a été retiré des favoris, met à jour l'apparence de l'étoile
                star.classList.remove("filled");
                star.textContent = "☆";
            } else if (xhr.responseText === "not_logged_in") {
                // Si l'utilisateur n'est pas connecté, affiche une alerte
                alert("Veuillez vous connecter pour gérer vos favoris.");
            } else {
                // Pour toute autre réponse, affiche un message d'erreur
                alert("Erreur : " + xhr.responseText);
            }
        } else {
            // Si le statut HTTP n'est pas 200, affiche une erreur de connexion
            alert("Erreur de connexion avec le serveur.");
        }
    };

    // Gère les erreurs de réseau
    xhr.onerror = function () {
        alert("Erreur réseau. Impossible de communiquer avec le serveur.");
    };

    // Envoie la requête avec l'ID du jeu en paramètre
    xhr.send("game_id=" + gameId);
}
