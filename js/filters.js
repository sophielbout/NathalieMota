jQuery(document).ready(function ($) {
    console.log('Début du script AJAX pour les taxonomies');

    // Charger les termes via AJAX
    $.ajax({
        url: natmota_ajax.url,
        type: 'POST',
        data: {
            action: 'get_taxonomies_terms',
        },
        success: function (response) {
            console.log('Réponse complète AJAX :', response);

            if (response.success) {
                const categorySelect = $('#filter-categories');
                const formatSelect = $('#filter-formats');

                // Vider les sélecteurs pour éviter les doublons
                categorySelect.empty().append('<option value="" disabled selected>CATÉGORIES</option>');
                formatSelect.empty().append('<option value="" disabled selected>FORMATS</option>');

                // Ajouter les options
                if (response.data.categories) {
                    response.data.categories.forEach(term => {
                        categorySelect.append(new Option(term.name, term.id));
                    });
                }
                if (response.data.formats) {
                    response.data.formats.forEach(term => {
                        formatSelect.append(new Option(term.name, term.id));
                    });
                }

                // Initialiser Select2
                $('.select2').select2();
            } else {
                console.error('Erreur lors de la récupération des termes :', response.data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Erreur AJAX :', textStatus, errorThrown);
        },
    });

    // Définir applyFilters comme fonction globale
    window.applyFilters = function () {
        const selectedCategory = $('#filter-categories').val();
        const selectedFormat = $('#filter-formats').val();
        const selectedSort = $('#filter-sort').val();

        console.log('Filtres sélectionnés :', {
            category: selectedCategory,
            format: selectedFormat,
            sort: selectedSort,
        });

        if (!selectedCategory && !selectedFormat && !selectedSort) {
            alert('Veuillez sélectionner au moins un filtre.');
            return;
        }

        // Appel AJAX pour appliquer les filtres
        $.ajax({
            url: natmota_ajax.url,
            type: 'POST',
            data: {
                action: 'filter_photos',
                category: selectedCategory,
                format: selectedFormat,
                sort: selectedSort,
            },
            success: function (response) {
                if (response.success) {
                    $('.photoblock-gallery').html(response.data.html);
                } else {
                    alert('Aucune photo trouvée pour ces critères.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Erreur AJAX :', textStatus, errorThrown);
            },
        });
    };
    jQuery(document).ready(function () {
        jQuery('.select2').select2();

        // Ouvrir la liste avec transition
        jQuery('.select2').on('select2:opening', function () {
            const dropdown = jQuery('.select2-dropdown');
            dropdown.css({
                height: '0', // Commence masquée
                overflow: 'hidden', // Empêche les débordements
            });

            // Calculer et appliquer la hauteur maximale
            setTimeout(function () {
                const contentHeight = dropdown.prop('scrollHeight') + 'px';
                dropdown.css({
                    height: contentHeight,
                    transition: 'height 0.5s ease',
                });
            }, 10);
        });

        // Fermer la liste avec transition
        jQuery('.select2').on('select2:closing', function () {
            const dropdown = jQuery('.select2-dropdown');
            dropdown.css({
                height: '0', // Réduit la hauteur à zéro
                overflow: 'hidden',
                transition: 'height 0.5s ease',
            });

            // Optionnel : Réinitialiser après la fermeture
            setTimeout(function () {
                dropdown.css({ height: '' }); // Nettoie la propriété pour l'état initial
            }, 500); // Attendre la fin de la transition
        });
    });

});
