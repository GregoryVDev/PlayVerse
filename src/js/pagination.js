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
      pageNumbers.style.display = "none";
    } else {
      document.getElementById("pagination").style.display = "flex"; // Affiche la pagination si plus d'une page
      pageNumbers.style.display = "block";

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
