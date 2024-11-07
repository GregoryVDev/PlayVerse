// Previsualisation des images choisies

document.addEventListener("DOMContentLoaded", function () {
  const iconInput = document.getElementById("icon");
  const previewImage = document.getElementById("previewImage");
  const uploadLabel = document.getElementById("uploadLabel");
  const deleteImageButton = document.getElementById("deleteImageButton");

  iconInput.addEventListener("change", function () {
    if (this.files && this.files[0]) {
      const reader = new FileReader();

      reader.onload = function (e) {
        previewImage.setAttribute("src", e.target.result);
        previewImage.style.display = "block"; // Show the image preview
        previewImage.style.margin = "20px auto";
        uploadLabel.style.display = "none"; // Hide the label
        deleteImageButton.style.display = "flex"; // Show the delete button
        deleteImageButton.style.background = "var(--colorBackOffice";
        deleteImageButton.style.color = "var(--colorPara)";
        deleteImageButton.style.margin = "auto auto 15px";
        deleteImageButton.style.borderRadius = "10px";
        deleteImageButton.style.padding = "5px 15px";
      };

      reader.readAsDataURL(this.files[0]);
    }
  });

  deleteImageButton.addEventListener("click", function () {
    iconInput.value = ""; // Clear the file input
    previewImage.setAttribute("src", ""); // Clear the image source
    previewImage.style.display = "none"; // Hide the image preview
    uploadLabel.style.display = "block"; // Show the label again
    deleteImageButton.style.display = "none"; // Hide the delete button
  });
});
