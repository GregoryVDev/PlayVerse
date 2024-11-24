document.addEventListener("DOMContentLoaded", function () {
  const searchForm = document.getElementById("searchForm");
  const searchInput = document.getElementById("search");

  // Écouteur sur le champ de recherche
  searchInput.addEventListener("keydown", function (event) {
    // Vérifie si l'utilisateur appuie sur Entrée
    if (event.key === "Enter") {
      event.preventDefault(); // Empêche le comportement par défaut
      searchForm.submit(); // Soumet le formulaire
    }
  });
});
