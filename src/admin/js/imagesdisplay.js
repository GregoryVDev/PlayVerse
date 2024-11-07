let preview;
let files;
let oldimg;
let typefileimg;

function countDivOctet(octets, nb) {
  if (octets < 1024) {
    return [octets, nb];
  }
  octets = octets / 1024;
  nb++;
  return countDivOctet(octets, nb);
}

function displayOctet(octets) {
  let nb = 0;
  let units = [" O", " KO", " MO", " GO", " TO"];
  let values = countDivOctet(octets, nb);
  return (
    "" +
    Number.parseFloat(Number.parseFloat(values[0]).toFixed(2)) +
    units[values[1]]
  );
}

function loadimg(src) {
  preview.src = src;
  preview.file = file;
}

function imgdef() {
  preview.src = oldimg;
  preview.file = undefined;
  typefileimg.type = "text";
  typefileimg.type = "file";
}

/*
Recuperation d'une image pour l'afficher sur le html
event (event) : evenement d'ecoute
*/
function loadFiles(event, idImg) {
  // on recupere la liste des fichiers
  files = event.target.files;
  image_id = idImg;
  // une boucle sur les fichiers telecharges
  for (var i = 0; i < files.length; i++) {
    // recuperation du fichier
    let file = files[i];
    // le type du fichier accepte
    let allowedTypes = ["image/jpg", "image/jpeg", "image/png", "image/webp"];
    let formatImgAccept = "PNG, JPG et WEBP";
    let maxFileSize = 2 * 1024 * 1024; // Limite de 2 Mo
    let maxWidth = 2040; // Largeur maximale en pixels
    let maxHeight = 2040; // Hauteur maximale en pixels

    // on vide l'image par defaut et on ajoute le fichier
    //preview.src = "";
    //preview.file = file;

    let valide_img = false;

    allowedTypes.forEach((element) => {
      if (element.toLowerCase() == file.type.toLowerCase()) {
        valide_img = true;
      }
    });

    if (!valide_img) {
      alert("Erreur : Format non autorisé. " + formatImgAccept + " acceptés.");
      valide_img = false;
      imgdef();
      return;
    }

    if (file.size > maxFileSize) {
      alert(
        "Erreur : La taille du fichier est trop grande. Limite de " +
          displayOctet(maxFileSize) +
          "."
      );
      valide_img = false;
      imgdef();
      return;
    }

    let _URL = window.URL || window.webkitURL;
    let img = new Image();
    let objectUrl = _URL.createObjectURL(file);
    img.onload = function () {
      let img_width = this.width;
      let img_height = this.height;
      if (img_width > maxWidth || img_height > maxHeight) {
        alert(
          "Erreur : Dimensions max " + maxWidth + "x" + maxHeight + " pixels."
        );
        valide_img = false;
        imgdef();
        return;
      }
      loadimg(this.src);
      _URL.revokeObjectURL(objectUrl);
    };
    img.src = objectUrl;
  }
}

function recupIdBtImg(event) {
  let idImgDef = event.currentTarget.parentNode.querySelector(".imgdef-all").id;
  let idImg = event.currentTarget.parentNode.querySelector(".disp-imgs").id;
  let idPas = event.currentTarget.parentNode.querySelector(".file-imgs").id;
  previewDef = document.getElementById(idImgDef);
  preview = document.getElementById(idImg);
  typefileimg = document.getElementById(idPas);
  oldimg = previewDef.value;
  loadFiles(event);
}

document.querySelectorAll(".file-imgs").forEach((element) => {
  element.addEventListener("change", recupIdBtImg);
});
