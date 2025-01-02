(function ($) {
    $(document).ready(function () {
        const loadMoreButton = $('#load-more-photos');

        if (loadMoreButton.length) {
            loadMoreButton.on('click', function () {
                const page = parseInt($(this).attr('data-page')) + 1; // Incrémenter la page
                const button = $(this);

                // Appel AJAX
                $.ajax({
                    url: natmota_ajax.url, // URL définie via PHP
                    type: 'POST',
                    data: {
                        action: 'load_more_photos', // Action PHP
                        page: page, // Page actuelle
                    },
                    beforeSend: function () {
                        button.text('Chargement...');
                    },
                    success: function (response) {
                        if (response.success) {
                            // Ajouter les nouvelles photos
                            $('.photoblock-gallery').append(response.data.content);

                            // Mettre à jour le numéro de page
                            button.attr('data-page', page);

                            // Vérifier s'il reste des photos
                            if (response.data.has_more) {
                                button.text('Charger plus');
                            } else {
                                button.text('Fin du portfolio');
                                button.prop('disabled', true);
                            }
                        } else {
                            console.error('Erreur serveur :', response.data.message);
                            button.text('Charger plus');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Erreur AJAX :', textStatus, errorThrown);
                        button.text('Charger plus'); // Réinitialiser le texte en cas d’erreur
                    },
                });
            });
        }
    });
})(jQuery);
