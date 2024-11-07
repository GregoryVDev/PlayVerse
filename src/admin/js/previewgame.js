function previewImage(input, previewId) {
  const previewContainer = document.getElementById(previewId);
  previewContainer.innerHTML = ""; // Réinitialiser le conteneur

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      const img = document.createElement("img");
      img.src = e.target.result;
      img.style.display = "block";
      img.style.margin = "20px auto";
      img.style.maxWidth = "235px";
      img.style.maxHeight = "235px";
      img.alt = "Prévisualisation de l'image";
      previewContainer.appendChild(img);

      // Ajout du bouton de suppression
      const removeButton = document.createElement("button");
      removeButton.innerText = "Supprimer";
      removeButton.style.display = "flex";
      removeButton.style.background = "var(--colorBackOffice";
      removeButton.style.color = "var(--colorPara)";
      removeButton.style.borderRadius = "10px";
      removeButton.style.margin = "15px auto";
      removeButton.style.padding = "5px 15px";
      removeButton.onclick = function () {
        input.value = ""; // Réinitialiser l'input
        previewContainer.innerHTML = ""; // On supprime la prévisualisation
      };
      previewContainer.appendChild(removeButton);
    };

    reader.readAsDataURL(input.files[0]);
  }
}
