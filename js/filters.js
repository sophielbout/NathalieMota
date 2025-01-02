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
    jQuery(document).ready(function ($) {
        window.applyFilters = function () {
            const selectedCategory = $('#filter-categories').val();
            const selectedFormat = $('#filter-formats').val();
            const selectedSort = $('#filter-sort').val();

            console.log('Filtres sélectionnés :', {
                category: selectedCategory,
                format: selectedFormat,
                sort: selectedSort,
            });

            // Vérifiez si des filtres ont été sélectionnés
            if (!selectedCategory && !selectedFormat && !selectedSort) {
                alert('Veuillez sélectionner au moins un filtre.');
                return;
            }
            console.log({
                action: 'filter_photos',
                category: $('#filter-categories').val(),
                format: $('#filter-formats').val(),
                sort: $('#filter-sort').val(),
            });

            // Appel AJAX
            $.ajax({
                url: natmota_ajax.url, // URL configurée dans wp_localize_script
                type: 'POST',
                data: {
                    action: 'filter_photos',
                    category: selectedCategory,
                    format: selectedFormat,
                    sort: selectedSort,
                },
                success: function (response) {
                    console.log('Réponse AJAX :', response);

                    if (response.success) {
                        $('.photoblock-gallery').html(response.data.html); // Met à jour la galerie
                        reinitializeEvents(); // Réattache les événements sur les nouveaux blocs
                    } else {
                        $('.photoblock-gallery').html('<p>Aucune photo trouvée.</p>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Erreur AJAX :', textStatus, errorThrown);
                },
            });
        };
    });

    // Réinitialise les événements pour Icon-fullscreen
    function reinitializeEvents() {
        console.log('Réinitialisation des événements pour les nouveaux blocs.');

        // Réattache les événements pour Icon-eye
        document.querySelectorAll('.card-photo .icon-eye').forEach(icon => {
            icon.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();

                const link = icon.dataset.link;
                if (link) {
                    window.location.href = link; // Redirige vers la page single
                } else {
                    console.error("Aucune URL trouvée pour cet élément.");
                }
            });
        });

        // Réattache les événements
        const modal = document.getElementById("lightboxModal");
        const modalPhoto = modal.querySelector(".lightbox-photo");
        let currentIndex = 0;
        let photos = [];

        document.querySelectorAll('.card-photo .icon-fullscreen').forEach((icon, index) => {
            photos.push({
                src: icon.dataset.src,
                ref: icon.dataset.ref,
                cat: icon.dataset.cat,
            });

            icon.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                currentIndex = index;
                openLightbox(currentIndex, photos, modal, modalPhoto);
            });
        });
    }

    function openLightbox(index, photos, modal, modalPhoto) {
        const photo = photos[index];
        if (!photo.src || !photo.src.startsWith("http")) {
            console.error("URL invalide pour la photo :", photo.src);
            return;
        }

        const content = `
            <img src="${photo.src}" alt="Photo en grand" class="lightbox-hero" />
            <div class="lightbox-info">
                <div class="info-wrapper">
                    <p class="reference">${photo.ref}</p>
                    <p class="category">${photo.cat}</p>
                </div>
            </div>
        `;

        modalPhoto.innerHTML = content;
        modal.style.display = "flex";
        modal.classList.add("show");
    }


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
