
    // Gestion du menu burger
    const burgerMenu = document.querySelector('.burger-menu');
    const menuOverlay = document.querySelector('.menu-overlay');
    burgerMenu.addEventListener('click', () => {
        burgerMenu.classList.toggle('active');
        menuOverlay.classList.toggle('active');
    });
    menuOverlay.addEventListener('click', (e) => {
        if (e.target.tagName === 'A') {
            burgerMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
        }
    });

document.addEventListener("DOMContentLoaded", () => {
    // Gestion de l'icône single (Icon-eye)
    document.querySelectorAll('.card-photo .icon-eye').forEach(icon => {
        icon.addEventListener('click', (e) => {
            e.stopPropagation(); // Empêche le clic de remonter
            e.preventDefault();  // Empêche tout comportement par défaut

            // Récupérer l'URL vers la single
            const link = icon.dataset.link;
            if (link) {
                window.location.href = link; // Redirige vers la page single
            } else {
                console.error("Aucune URL trouvée pour cet élément.");
            }
        });
    });
});
