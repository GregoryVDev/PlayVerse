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
