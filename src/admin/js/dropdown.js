// DROPDOWN PLATEFORMES

// Ouvre ou ferme le dropdown au clique du bouton
function toggleDropdown(event) {
  // la fermeture immédiate après l'ouverture est empêchée
  event.stopPropagation();
  document.querySelector(".container-plateformes").classList.toggle("active");
}

// Ferme le dropdown quand on clique sur la page n'importe où
window.onclick = function (event) {
  // Vérifie si le dropdown est ouvert
  const dropdownContainer = document.querySelector(".container-plateformes");
  if (
    // Si le dropdown a la classe 'active'
    dropdownContainer.classList.contains("active") &&
    // si l'élément cliqué n'est pas dans le dropdown
    !event.target.closest(".container-plateformes")
  ) {
    // Supression de la classe 'active' pour fermer le dropdown
    dropdownContainer.classList.remove("active");
  }
};

// Ajoute le gestionnaire d'événement au bouton dropdown
document
  .querySelector(".dropdown-btn")
  .addEventListener("click", toggleDropdown);
