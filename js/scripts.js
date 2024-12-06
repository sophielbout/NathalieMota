jQuery(document).ready(function($) {
    // Gérer les déclencheurs de modale
    jQuery('.open-modal').on('click', function(e) {
        initModal(e, true);
    });

    // Gestion du bouton Contact dans le menu desktop
    jQuery('#menu-item-37').on('click', function(e) {
        initModal(e);
    });

    // Gestion du bouton Contact dans le menu overlay
    jQuery('.menu-overlay .menu-item-37').on('click', function(e) {
        initModal(e); // Appelle la même fonction pour afficher la modale
    });
});

function initModal(e, autoFillRef = false) {
    e.preventDefault();

    // Récupérer la référence depuis le bouton cliqué
    let reference = jQuery('.open-modal').data('ref');
    let refInput = jQuery('input[name="ref-photo"]');

    // Préremplir le champ "ref-photo" si le formulaire et la référence existent et si autoFillRef est true
    if (refInput.length && reference && autoFillRef) {
        refInput.val(reference);
    }

    // Afficher la modale
    jQuery('#myModal').addClass('show'); // Ajoute la classe 'show' pour afficher
}

// Gérer la fermeture de la modale
jQuery('#myModal').on('click', function(e) {
    // Ferme la modale uniquement si le clic est sur l'arrière-plan ou le bouton "close"
    if (jQuery(e.target).is('.modal, .close') && !jQuery(e.target).closest('a[href="#myModal"]').length) {
        jQuery(this).removeClass('show'); // Supprime la classe 'show' pour masquer
    }
});
jQuery('a[href="#myModal"]').on('click', function(e) {
    e.preventDefault(); // Empêche le comportement par défaut du lien
    e.stopPropagation(); // Empêche le clic de se propager au parent `.modal`

    // Ouvre la modale
    jQuery('#myModal').addClass('show');
});


document.addEventListener('DOMContentLoaded', () => {
    // Gestion des clics sur l'icône fullscreen
    document.querySelectorAll('.card-photo .photo-overlay').forEach((overlay) => {
        overlay.addEventListener('click', (event) => {
            const target = event.target;
            if (getComputedStyle(target, '::before').content !== 'none') {
                event.preventDefault();
                openFullscreenModal(overlay);
            }
        });
    });

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
});

document.addEventListener('DOMContentLoaded', () => {
    // L'élément HTML où afficher l'image
    const imageContainer = document.querySelector('#random-image');

    if (imageContainer) {
        // Appeler le backend pour récupérer une image aléatoire
        fetch('get-images.php')
            .then(response => response.json())
            .then(data => {
                if (data.image) {
                    imageContainer.src = data.image; // Mettre à jour la source de l'image
                } else {
                    console.error(data.error || "An error occurred");
                }
            })
            .catch(error => console.error("Error fetching image:", error));
    }
});
