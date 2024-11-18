document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('myModal');

    // Trouver le lien "Contact" dans le menu par son texte
    const contactLink = Array.from(document.querySelectorAll('nav a'))
        .find(link => link.textContent.trim() === 'Contact');

    if (contactLink && modal) {
        contactLink.addEventListener('click', function (event) {
            event.preventDefault(); // Empêche la redirection
            modal.style.display = 'flex'; // Affiche la modale
            setTimeout(() => modal.classList.add('show'), 10); // Ajoute la classe après un léger délai
        });
    }

    // Configuration pour fermer la modale
    const closeModal = document.querySelector('.modal .close');
    if (closeModal) {
        closeModal.addEventListener('click', function () {
            modal.classList.remove('show'); // Retire la classe pour l'animation inverse
            setTimeout(() => modal.style.display = 'none', 500); // Cache complètement après l'animation
        });
    }

    // Ferme la modale si on clique en dehors
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 500); // Cache complètement après l'animation
        }
    });
});
