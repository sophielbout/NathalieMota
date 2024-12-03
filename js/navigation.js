jQuery(document).ready(function ($) {
    // Gérer le survol de la flèche
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
