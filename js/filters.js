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
                // Remplir le menu "Catégories"
                const categorySelect = $('#filter-categories');
                if (response.data.categories) {
                    console.log('Ajout des catégories :', response.data.categories);
                    response.data.categories.forEach(term => {
                        categorySelect.append(new Option(term.name, term.id));
                    });
                }

                // Remplir le menu "Formats"
                const formatSelect = $('#filter-formats');
                if (response.data.formats) { // Changer 'format' en 'formats'
                    console.log('Ajout des formats :', response.data.formats);
                    response.data.formats.forEach(term => {
                        formatSelect.append(new Option(term.name, term.id));
                    });
                }

                // Initialiser Select2 après avoir ajouté les options
                $('.select2').select2();
            } else {
                console.error('Erreur lors de la récupération des termes :', response.data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Erreur AJAX :', jqXHR, textStatus, errorThrown);
        },
    });
});
