document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('myModal');
    const contactLink = document.querySelector('a[href="#myModal"]');

    // Ouvrir la modale au clic sur le lien "Contact"
    contactLink.addEventListener('click', function (event) {
        event.preventDefault();  // Empêche la redirection par défaut
        modal.classList.add('show');  // Affiche la modale avec l'animation
    });

    // Fermer la modale au clic en dehors de la modale
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {  // Si on clique sur le fond
            modal.classList.remove('show');  // Ferme la modale avec l'animation
        }
    });

    // Optionnel : fermer la modale au clic sur le bouton "X"
    const closeButton = modal.querySelector('.close');
    closeButton.addEventListener('click', function () {
        modal.classList.remove('show');  // Ferme la modale
    });
});
