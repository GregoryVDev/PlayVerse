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
        uploadLabel.style.display = "none"; // Hide the label
        deleteImageButton.style.display = "inline"; // Show the delete button
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
