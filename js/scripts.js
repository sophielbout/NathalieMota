
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


   /* document.addEventListener('DOMContentLoaded', () => {
        // L'élément où mettre le background dynamique
        const heroImage = document.querySelector('.hero-image');

        if (heroImage) {
            // Appeler le backend pour récupérer une image aléatoire
            fetch('get-images.php')
                .then(response => response.json())
                .then(data => {
                    if (data.image) {
                        // Mettre à jour le background-image dynamiquement
                        heroImage.style.backgroundImage = `url(${data.image})`;
                    } else {
                        console.error(data.error || "An error occurred");
                    }
                })
                .catch(error => console.error("Error fetching image:", error));
        }
    });*/

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
