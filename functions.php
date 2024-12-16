<?php
/**
 * Functions and definitions for NMota Theme
 *
 * @package NMota
 * @since 1.0.0
 */

/**
 * Enqueues stylesheets and JavaScript files.
 */
function natmota_enqueue_assets() {
    // Charger le style du thème parent, mais pas dans l'admin
    if (!is_admin()) {
        wp_enqueue_style(
            'parent-style',
            get_template_directory_uri() . '/style.css'
        );

        // Charger le CSS compilé par Sass, mais uniquement sur le front-end
        if (file_exists(get_stylesheet_directory() . '/css/main.css')) {
            wp_enqueue_style(
                'natmota-main-style',
                get_stylesheet_directory_uri() . '/css/main.css',
                array('parent-style'),
                filemtime(get_stylesheet_directory() . '/css/main.css'),
                'all'
            );
        }

        // Charger le fichier JS personnalisé pour la modale ou autre
        wp_enqueue_script(
            'natmota-modal-script',
            get_stylesheet_directory_uri() . '/js/scripts.js',
            array('jquery'), // Ajout de dépendances
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'natmota_enqueue_assets');

/**
 * Registers navigation menus.
 */
function natmota_register_menus() {
    register_nav_menus(array(
        'main-menu' => __('Menu principal', 'nmota'),
        'footer-menu' => __('Menu de pied de page', 'nmota'),
    ));
}
add_action('after_setup_theme', 'natmota_register_menus');

/**
 * Charge jQuery si non disponible
 */
function load_jquery_script() {
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'load_jquery_script');

/**
 * Charger les scripts personnalisés
 */
function enqueue_custom_scripts() {
    wp_enqueue_script(
        'custom-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        ['jquery'],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/**
 * Ajouter des tailles d'images personnalisées
 */
function ajouter_tailles_images_personnalisees() {
    add_image_size('taille-hero', 1440, 962, true);
    add_image_size('taille-featured-image', 563, 0, false);
    add_image_size('taille-photo-block', 564, 495, true);
    add_image_size('taille-featured-mobile', 265, 0, false);
}
add_action('after_setup_theme', 'ajouter_tailles_images_personnalisees');

/**
 * Fonction AJAX pour charger plus de photos
 */
function natmota_load_more_photos() {
    // Vérifier si "page" est bien transmis et valide
    if (!isset($_POST['page']) || !is_numeric($_POST['page'])) {
        wp_send_json_error(array('message' => 'Paramètre "page" manquant ou invalide.'));
    }

    $paged = intval($_POST['page']);

    // Arguments pour WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged, // Page actuelle
    );

    $query = new WP_Query($args);

    // Si des posts sont trouvés
    if ($query->have_posts()) {
        ob_start(); // Commence à capturer la sortie

        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="card-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('taille-photo-block'); ?>
                    <div class="photo-overlay">
                        <span class="photo-reference">
                            <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée'); ?>
                        </span>
                        <span class="photo-category">
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'categories');
                            echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';
                            ?>
                        </span>
                    </div>
                </a>
            </div>
            <?php
        endwhile;

        $content = ob_get_clean(); // Capture la sortie

        // Vérifie s'il reste des photos à charger
        $has_more = $paged < $query->max_num_pages;

        wp_send_json_success(array(
            'content' => $content,
            'has_more' => $has_more,
        ));
    } else {
        wp_send_json_error(array('message' => 'Aucune photo trouvée.'));
    }

    // Toujours arrêter l'exécution de PHP après une réponse AJAX
    wp_die();
}

add_action('wp_ajax_load_more_photos', 'natmota_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'natmota_load_more_photos');

/**
 * Charger le script AJAX et localiser les données
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'natmota-ajax',
        get_template_directory_uri() . '/js/ajax.js',
        array('jquery'),
        null,
        true
    );
    wp_localize_script('natmota-ajax', 'natmota_ajax', array(
        'url' => admin_url('admin-ajax.php'),
    ));
});

 // Chargement de Select2

 add_action('wp_enqueue_scripts', function () {
    // Charger Select2 CSS et JS
    wp_enqueue_style(
        'select2-css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css'
    );
    wp_enqueue_script(
        'select2-js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
        ['jquery'],
        null,
        true
    );

    // Charger le script personnalisé pour gérer les filtres
    wp_enqueue_script(
        'natmota-filters',
        get_template_directory_uri() . '/js/filters.js',
        ['jquery', 'select2-js'],
        null,
        true
    );

    // Charger le script pour la pagination infinie
    wp_enqueue_script(
        'natmota-ajax',
        get_template_directory_uri() . '/js/ajax.js',
        ['jquery'],
        null,
        true
    );

    // Passer les paramètres AJAX aux scripts
    wp_localize_script('natmota-ajax', 'natmota_ajax', [
        'url' => admin_url('admin-ajax.php'),
        'actions' => [
            'load_more_photos' => 'load_more_photos',
            'get_taxonomies_terms' => 'get_taxonomies_terms',
        ],
    ]);
});



// Action pour les filtres
add_action('wp_ajax_get_taxonomies_terms', 'natmota_get_taxonomies_terms');
add_action('wp_ajax_nopriv_get_taxonomies_terms', 'natmota_get_taxonomies_terms');

function natmota_get_taxonomies_terms() {
    error_log('natmota_get_taxonomies_terms appelée');

    $results = array();

    // Récupérer les termes pour la taxonomie "categories"
    $categories = get_terms([
        'taxonomy' => 'categories',
        'hide_empty' => true,
    ]);

    if (!is_wp_error($categories) && !empty($categories)) {
        error_log('Catégories récupérées : ' . print_r($categories, true));
        $results['categories'] = array_map(function ($term) {
            return [
                'id' => $term->slug,
                'name' => $term->name,
            ];
        }, $categories);
    }

    // Récupérer les termes pour la taxonomie "formats"
    $formats = get_terms([
        'taxonomy' => 'formats',
        'hide_empty' => true,
    ]);

    if (!is_wp_error($formats) && !empty($formats)) {
        error_log('Formats récupérés : ' . print_r($formats, true));
        $results['formats'] = array_map(function ($term) {
            return [
                'id' => $term->slug,
                'name' => $term->name,
            ];
        }, $formats);
    }

    wp_send_json_success($results);
    wp_die();
}


function natmota_filter_photos() {

    // Récupérer les données POST
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : null;
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : null;
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'desc';

    // Préparer les arguments de WP_Query
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => $sort,
        'tax_query' => [], // Initialiser une tax_query vide
    ];

    // Ajouter le filtre "catégorie" si défini
    if ($category) {
        $args['tax_query'][] = [
            'taxonomy' => 'categories',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    // Ajouter le filtre "format" si défini
    if ($format) {
        $args['tax_query'][] = [
            'taxonomy' => 'formats',
            'field'    => 'slug',
            'terms'    => $format,
        ];
    }

    // Exécuter la requête WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="card-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('taille-photo-block'); ?>
                    <div class="photo-overlay">
                        <span class="photo-reference">
                            <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée'); ?>
                        </span>
                        <span class="photo-category">
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'categories');
                            echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';
                            ?>
                        </span>
                    </div>
                </a>
            </div>
            <?php
        }
        wp_reset_postdata();

        // Renvoyer les résultats au format JSON
        wp_send_json_success(['html' => ob_get_clean()]);
    } else {
        wp_send_json_error(['message' => 'Aucune photo trouvée pour ces critères.']);
    }

    wp_die();
}

add_action('wp_ajax_filter_photos', 'natmota_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'natmota_filter_photos');
