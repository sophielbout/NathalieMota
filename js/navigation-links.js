document.addEventListener("DOMContentLoaded", () => {
    // Sélection des flèches
    const prevArrow = document.querySelector(".prev-arrow");
    const nextArrow = document.querySelector(".next-arrow");

    // Fonction pour afficher la miniature au survol
    function handleHover(event) {
        const miniature = this.querySelector(".miniature");
        if (miniature) {
            miniature.style.display = "block";
            miniature.style.opacity = "1";
        }
    }

    // Fonction pour masquer la miniature au survol
    function handleMouseOut(event) {
        const miniature = this.querySelector(".miniature");
        if (miniature) {
            miniature.style.display = "none";
            miniature.style.opacity = "0";
        }
    }

    // Associer les événements de survol aux flèches
    if (prevArrow) {
        prevArrow.addEventListener("mouseenter", handleHover);
        prevArrow.addEventListener("mouseleave", handleMouseOut);
    }

    if (nextArrow) {
        nextArrow.addEventListener("mouseenter", handleHover);
        nextArrow.addEventListener("mouseleave", handleMouseOut);
    }
});
