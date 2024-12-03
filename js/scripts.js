jQuery(document).ready(function($) {
    // Gérer les déclencheurs de modale
    jQuery('.open-modal').on('click', function(e) {
       initModal(e, true);
    });
    jQuery('#menu-item-37').on('click', function(e) {
        initModal(e);
     });
});

function initModal(e, autoFillRef=false) {
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
};


// Gérer la fermeture de la modale
jQuery('#myModal').on('click', function(e) {
    if (jQuery(e.target).is('.modal, .close')) {
        jQuery(this).removeClass('show'); // Supprime la classe 'show' pour masquer
    }
});