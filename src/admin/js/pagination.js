document.addEventListener("DOMContentLoaded", function () {
  const articlesPerPage = 15; // On affiche une limitation de 15 articles par page
  const articles = document.querySelectorAll(".dashboard table tbody tr"); // On sélectionne des class dashboard et des balises tables, tbody et tr
  const totalPages = Math.ceil(articles.length / articlesPerPage); // Calcule le nombre de pages en divisant le nombre total d'articles et l'arrondir supérieurement pour avoir assez de page pour les articles
  let currentPage = 1; // page par défaut

  function showPage(page) {
    const start = (page - 1) * articlesPerPage; // index commencera à 0
    const end = start + articlesPerPage;

    // Parcourt chaque élément de la liste d'articlesd
    articles.forEach((article, index) => {
      // Si l'index de l'article est compris entre les valeurs "start" et "end", il sera affiché, sinon il sera masqué
      article.style.display =
        index >= start && index < end ? "table-row" : "none";
    });

    const pageNumbers = document.getElementById("pageNumbers"); // récupération des chiffres de page
    pageNumbers.innerHTML = ""; // Réinitialiser la pagination avant d'ajouter de nouveaux numéros pour éviter d'avoir des erreurs et que les numéros se dubliquent

    // Vérifie s'il y a plus d'une page en tout
    if (totalPages > 1) {
      // Affiche la pagination seulement si totalPages > 1
      // Si oui, affiche la pagination en générant les numéros de page
      // Pour chaque page (de 1 jusqu'au nombre total de pages) :
      for (let i = 1; i <= totalPages; i++) {
        const pageNumber = document.createElement("span");

        pageNumber.textContent = i; // Page actuelle (1)
        pageNumber.className = "page-number"; // On attribut la classe page-number
        pageNumber.style.cursor = "pointer"; // On lui met un style cursor pointer

        // Si la page actuelle (i = 1) est strictement égale à la page actuelle
        if (i === currentPage) {
          pageNumber.style.fontWeight = "bold"; // On met en gras la page actuelle
          pageNumber.style.color = "var(--colorTitle)"; // Une couleur
        }

        // On rajoute un event listener au click
        pageNumber.addEventListener("click", () => {
          currentPage = i; // On actualise la page où on a cliqué sur le numéro
          showPage(currentPage); // On affiche la 2e page
        });

        // Ajoute l'élément <span> (numéro de page) au conteneur "pageNumbers" dans le HTML
        pageNumbers.appendChild(pageNumber);

        // Si la page actuelle est inférieur au nombre total de page
        if (i < totalPages) {
          pageNumbers.appendChild(document.createTextNode(" ")); // Ajoute un espace entre les numéros de page, sauf pour le dernier
        }
      }
      document.getElementById("pagination").style.display = "flex"; // On affichela pagination avec un display flex pour que les chiffres soient l'un à côté de l'autre
    } else {
      // Si le nombre total de pages est inférieur ou égal à 1, on cache la pagination
      document.getElementById("pagination").style.display = "none";
    }
  }
  // On affiche la page actuelle en appelant la fonction avec currentPage qui est par défaut (1)
  showPage(currentPage);
});
