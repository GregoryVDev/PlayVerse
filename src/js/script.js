document.querySelectorAll(".input-wrapper input").forEach((input) => {
  input.addEventListener("focus", () => {
    // Cacher toutes les images
    document.querySelectorAll(".input-wrapper img").forEach((img) => {
      img.style.display = "none";
    });
    // Afficher l'image correspondante
    const img = input.previousElementSibling;
    img.style.display = "block";
  });

  input.addEventListener("blur", () => {
    // Cacher l'image lorsque l'input perd le focus
    const img = input.previousElementSibling;
    img.style.display = "none";
  });
});

// Gérer le champ de texte pour le message
const messageInput = document.querySelector("#message");
const messageImg = document.querySelector(".full-width img");

messageInput.addEventListener("focus", () => {
  // Cacher toutes les images
  document.querySelectorAll(".input-wrapper img").forEach((img) => {
    img.style.display = "none";
  });
  // Afficher l'image du message
  messageImg.style.display = "block";
});

messageInput.addEventListener("blur", () => {
  // Cacher l'image du message lorsque l'input perd le focus
  messageImg.style.display = "none";
});

// Carousel index
const carousel = document.getElementById("carousel");
const cards = Array.from(document.querySelectorAll(".card-carrousel"));
const cardWidth = cards[0].offsetWidth + 20; // Largeur de chaque carte (200px + 20px de marge)
let scrollPosition = 0;
let autoScrollInterval;

// Ajouter des clones des cartes pour éviter le blanc à droite
function duplicateCards() {
  const visibleCards = Math.ceil(window.innerWidth / cardWidth) + 1; // Cartes visibles à l'écran plus une supplémentaire
  for (let i = 0; i < visibleCards; i++) {
    cards.forEach((card) => {
      const clone = card.cloneNode(true);
      carousel.appendChild(clone);
    });
  }
}

duplicateCards(); // Dupliquer suffisamment de cartes pour éviter l'espace blanc

function toggleFavorite(star) {
  star.classList.toggle("filled");
}

function startAutoScroll() {
  autoScrollInterval = setInterval(() => {
    scrollPosition -= 1; // Avancer d'un pixel à chaque tick

    // Appliquer la translation
    carousel.style.transform = `translateX(${scrollPosition}px)`;

    // Lorsque la première carte sort de l'écran, la déplacer à la fin sans créer de saut visible
    const firstCard = carousel.firstElementChild;
    if (firstCard.getBoundingClientRect().right <= 0) {
      carousel.appendChild(firstCard); // Déplacer la première carte à la fin
      scrollPosition += cardWidth; // Ajuster la position pour éviter un décalage visible
      carousel.style.transform = `translateX(${scrollPosition}px)`; // Appliquer l'ajustement immédiatement
    }
  }, 18); // Ajuster la vitesse du défilement en modifiant cet intervalle
}

// Fonction pour arrêter le défilement automatique
function stopAutoScroll() {
  clearInterval(autoScrollInterval);
}

// Démarrer le défilement automatique
startAutoScroll();

// Arrêter le défilement lors du survol
carousel.addEventListener("mouseenter", stopAutoScroll);

// Reprendre le défilement lorsque la souris quitte
carousel.addEventListener("mouseleave", startAutoScroll);

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
