// MENU BURGER

let burgerMenu = document.getElementById("burger-menu");
let overlay = document.getElementById("nav");
burgerMenu.addEventListener("click", function () {
  this.classList.toggle("close");
  overlay.classList.toggle("overlay");
});

// DROPDOWN

// Fonction pour basculer l'affichage du dropdown et la flèche
function toggleDropdown() {
  // On récupère le dropdown
  let dropdown = document.querySelector(".dropdown");

  // On bascule la classe 'active' pour ouvrir/fermer le menu et changer la flèche
  dropdown.classList.toggle("active");

  // On gère l'affichage du dropdown
  let dropdownContent = dropdown.querySelector(".dropdown-content");
  if (dropdown.classList.contains("active")) {
    dropdownContent.style.display = "block"; // Affiche le menu
    // Utiliser setTimeout pour permettre aux transitions CSS de se produire
    setTimeout(() => {
      dropdownContent.style.opacity = "1"; // Définit l'opacité à 1 pour la transition
      dropdownContent.style.transform = "translateY(0)"; // Définit la transformation pour l'animation
    }, 10);
  } else {
    dropdownContent.style.opacity = "0"; // Définit l'opacité à 0 pour la transition
    dropdownContent.style.transform = "translateY(-10px)"; // Réduit la transformation pour l'animation
    // Utiliser setTimeout pour masquer le menu après la transition
    setTimeout(() => {
      dropdownContent.style.display = "none"; // Cache le menu
    }, 300); // Doit correspondre à la durée de la transition CSS
  }
}

// Optionnel: pour fermer le menu si on clique ailleurs sur la page
window.onclick = function (event) {
  if (!event.target.matches(".dropdown > a")) {
    let dropdowns = document.getElementsByClassName("dropdown");
    for (let i = 0; i < dropdowns.length; i++) {
      let openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("active")) {
        openDropdown.classList.remove("active");
        openDropdown.querySelector(".dropdown-content").style.display = "none"; // Cache le menu
      }
    }
  }
};
