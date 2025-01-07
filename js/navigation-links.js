jQuery(document).ready(function ($) {
    // Gérer le survol des flèches (précédent et suivant)
    $(".nav-arrow").hover(
        function () {
            // Affiche la vignette correspondante
            $(this).find(".miniature").fadeIn();
        },
        function () {
            // Cache la vignette correspondante
            $(this).find(".miniature").fadeOut();
        }
    );
});
