document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('myModal');
    const modalLinks = document.querySelectorAll('a[href="#myModal"]'); // Cible tous les boutons

    // Ajoute un événement "click" à chaque bouton
    modalLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Empêche la redirection par défaut
            modal.classList.add('show'); // Ajoute la classe pour afficher la modale
        });
    });

    // Ferme la modale au clic sur le fond
    modal.addEventListener('click', function (event) {
        if (event.target === modal) { // Si on clique en dehors du contenu
            modal.classList.remove('show'); // Retire la classe pour cacher la modale
        }
    });

    // Ferme la modale au clic sur le bouton "X"
    const closeButton = modal.querySelector('.close');
    if (closeButton) {
        closeButton.addEventListener('click', function () {
            modal.classList.remove('show');
        });
    }
});
