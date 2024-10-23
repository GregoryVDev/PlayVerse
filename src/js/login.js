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
