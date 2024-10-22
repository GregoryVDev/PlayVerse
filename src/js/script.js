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

// PAGINATION

document.addEventListener("DOMContentLoaded", function () {
  const articlesPerPage = 15; // On affiche une limitation de 3 articles par page
  const articles = document.querySelectorAll(
    ".container-favoris .card, .container-reviews .review"
  ); // Séléction des class container-favoris et card et on récupère les articles à l'intérieur
  const totalPages = Math.ceil(articles.length / articlesPerPage); // Calcule le nombre de pages en divisant le nombre total d'articles et l'arrondir supérieurement pour avoir assez de page pour les articles
  let currentPage = 1; // Page par défaut

  function showPage(page) {
    const start = (page - 1) * articlesPerPage; // L'index commencera à 0 donc on aura les index 0,1,2 sur la page 1
    const end = start + articlesPerPage; // On va afficher les index 3,4,5

    // On parcourt chaques articles dans la liste
    articles.forEach((article, index) => {
      if (index >= start && index < end) {
        article.style.display = "block"; // Permet d'afficher les 3 articles
      } else {
        article.style.display = "none"; // Permet de cacher les autres articles
      }
    });

    const prevPageButton = document.getElementById("prevPage");

    if (page === 1) {
      prevPageButton.style.display = "none";
    } else {
      prevPageButton.style.display = "flex";
      prevPageButton.style.gap = "5px";
    }

    const nextPageButton = document.getElementById("nextPage");

    if (page === totalPages) {
      nextPageButton.style.display = "none";
    } else {
      nextPageButton.style.display = "flex";
      nextPageButton.style.gap = "5px";
    }

    const pageNumbers = document.getElementById("pageNumbers");
    pageNumbers.innerHTML = ""; // Vide l'élément du html pour remettre à jour quand on change de page

    for (let i = 1; i <= totalPages; i++) {
      // On rajoute une page jusqu'à atteindre la page demandée
      const pageNumber = document.createElement("span");
      pageNumber.textContent = i; // Mise à jour de "i"
      pageNumber.className = "page-number";
      pageNumber.style.cursor = "pointer";

      if (i === currentPage) {
        pageNumber.style.fontWeight = "bold"; // On ajoute en gras la page où on se retrouve
      }

      pageNumber.addEventListener("click", () => {
        currentPage = i; // On met l'index à jour pour savoir la page actuelle
        showPage(currentPage);
      });
      pageNumbers.appendChild(pageNumber);

      if (i < totalPages) {
        pageNumbers.appendChild(document.createTextNode(" ")); // Ajout d'un espace entre les chiffres tant que totalPages est supérieur à la page actuelle
      }
    }
    if (totalPages <= 1) {
      document.getElementById("pagination").style.display = "none"; // Cache la pagination entière s'il n'y a qu'une seule page
    } else {
      document.getElementById("pagination").style.display = "flex"; // Affiche la pagination si plus d'une page

      if (page === 1) {
        prevPageButton.style.display = "none";
      } else {
        prevPageButton.style.display = "flex";
        prevPageButton.style.gap = "5px";
      }

      if (page === totalPages) {
        nextPageButton.style.display = "none";
      } else {
        nextPageButton.style.display = "flex";
        nextPageButton.style.gap = "5px";
      }
    }
  }

  document.getElementById("prevPage").addEventListener("click", function () {
    if (currentPage > 1) {
      currentPage--;
      showPage(currentPage);
    }
  });

  document.getElementById("nextPage").addEventListener("click", function () {
    if (currentPage < totalPages) {
      currentPage++;
      showPage(currentPage);
    }
  });

  showPage(currentPage);
});

// AFFICHER LE MOT DE PASSE (VISIBILITY)

document.addEventListener("DOMContentLoaded", function () {
  // On récupère toutes les class "toggle-password"
  const eyeIcons = document.querySelectorAll(".toggle-password");
  // On récupère l'id pass dans l'input password
  const passInput = document.getElementById("pass");
  // On récupère l'id pass2 dans l'input password confirm
  const passConfirm = document.getElementById("pass2");
  // On récupère l'id passCo dans l'input connexion
  const passConnect = document.getElementById("passCo");

  // On réalise une boucle pour chaque icon qui est affichée
  eyeIcons.forEach(function (eyeIcon) {
    // On ajoute un event click dans la fonction "eyeIcon"
    eyeIcon.addEventListener("click", function () {
      // On vérifie quel icon (this) appartient à quel input (previousElementSibling)

      // Si l'icone adéquat de l'input est strictement égale au type pasword alors il devient un type text
      if (this.previousElementSibling.type === "password") {
        this.previousElementSibling.type = "text";
        // Sinon il redevient type mot de passe
      } else {
        this.previousElementSibling.type = "password";
      }
    });
  });
});
