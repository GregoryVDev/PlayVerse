// Fonction pour afficher ou masquer la flèche en fonction du défilement
function toggleScrollTopButton() {
  let scrollButton = document.getElementById("scroll-to-top");
  if (window.scrollY > 100 && !scrollButton.classList.contains("visible")) {
    scrollButton.classList.add("visible"); // Si on descend en dessous de 100px, alors on affiche l'image
  } else if (
    window.scrollY <= 100 &&
    scrollButton.classList.contains("visible") // Sinon, si on est à moins de 100px du haut et que la classe "visible" est appliquée
  ) {
    scrollButton.classList.remove("visible"); // On retire la visibilité et elle n'est plus affichée
  }
}

// Fonction pour faire défiler doucement vers le haut de la page
function scrollToTop() {
  window.scrollTo({
    top: 0, // Atteint le haut de la page
    behavior: "smooth", // Permet de remonter en haut de la page fluidement
  });
}

// On ajoute un évenement de scroll à la fenetre dans la fonction toggleScrollTopButton
window.addEventListener("scroll", toggleScrollTopButton);

// On ajoute un évenement qui se déclenche lorsque la page est entièrement chargée
window.addEventListener("load", function () {
  // On appelle la fonction après un délais de 100ms
  setTimeout(toggleScrollTopButton, 100);
});

// On sélectionne ce qui est dans le <a> et on met un évenement click
document
  .querySelector("#scroll-to-top a")
  .addEventListener("click", function (e) {
    e.preventDefault(); // Empêche le comportement par défaut du clic (téléportation en haut directement)
    scrollToTop(); // On appel la fonction scrollToTop pour défiler doucement vers le haut de la page
  });
