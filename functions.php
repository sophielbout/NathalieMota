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
    if (!is_admin()) {
        // Styles
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('main-styles', get_template_directory_uri() . '/css/main.css', [], '1.0.0');


        if (file_exists(get_stylesheet_directory() . '/css/main.css')) {
            wp_enqueue_style(
                'natmota-main-style',
                get_stylesheet_directory_uri() . '/css/main.css',
                array('parent-style'),
                filemtime(get_stylesheet_directory() . '/css/main.css'),
                'all'
            );
        }

        // Scripts
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'natmota-modal-script',
            get_stylesheet_directory_uri() . '/js/scripts.js',
            ['jquery'],
            null,
            true
        );

        wp_enqueue_script(
            'modal-js',
            get_template_directory_uri() . '/js/modal.js',
            ['jquery'],
            null,
            true
        );

        wp_enqueue_script(
            'photo-blocks-js',
            get_template_directory_uri() . '/js/lightbox.js',
            ['jquery', 'modal-js'],
            null,
            true
        );

        wp_enqueue_script(
            'natmota-ajax',
            get_template_directory_uri() . '/js/ajax.js',
            ['jquery'],
            null,
            true
        );

        wp_enqueue_script(
            'natmota-filters',
            get_template_directory_uri() . '/js/filters.js',
            ['jquery', 'select2-js'],
            null,
            true
        );

        wp_localize_script('natmota-ajax', 'natmota_ajax', [
            'url' => admin_url('admin-ajax.php'),
            'actions' => [
                'load_more_photos' => 'load_more_photos',
                'get_taxonomies_terms' => 'get_taxonomies_terms',
                'filter_photos' => 'filter_photos', // Ajout de l'action pour les filtres
            ],
        ]);
    }

    // Select2 (CSS & JS)
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
}
add_action('wp_enqueue_scripts', 'natmota_enqueue_assets');

add_action('wp_enqueue_scripts', function () {
    if (is_page('gallery') || is_singular('photo')) {
        wp_enqueue_script('lightbox-js', get_template_directory_uri() . '/js/lightbox.js', ['jquery'], null, true);
            }
});


/**
 * Registers navigation menus.
 */
function natmota_register_menus() {
    register_nav_menus([
        'main-menu'   => __('Menu principal', 'nmota'),
        'footer-menu' => __('Menu de pied de page', 'nmota'),
    ]);
}
add_action('after_setup_theme', 'natmota_register_menus');

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

// Inclure navigation-links.js
function enqueue_navigation_links_script() {
    if (is_singular('photo')) {
        wp_enqueue_script(
            'navigation-links',
            get_template_directory_uri() . '/js/navigation-links.js',
            ['jquery'],
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_navigation_links_script');

/**
 * Fonction AJAX pour charger plus de photos.
 */
function natmota_load_more_photos() {
    if (!isset($_POST['page']) || !is_numeric($_POST['page'])) {
        wp_send_json_error(['message' => 'Paramètre "page" manquant ou invalide.']);
    }

    $paged = intval($_POST['page']);
    $args = [
        'post_type'      => 'photos',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
    ];

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

        wp_send_json_success([
            'content'  => ob_get_clean(),
            'has_more' => $paged < $query->max_num_pages,
        ]);
    } else {
        wp_send_json_error(['message' => 'Aucune photo trouvée.']);
    }

    wp_die();
}
add_action('wp_ajax_load_more_photos', 'natmota_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'natmota_load_more_photos');

/**
 * Fonction AJAX pour récupérer les filtres (taxonomies).
 */
function natmota_get_taxonomies_terms() {
    $results = [];

    $categories = get_terms(['taxonomy' => 'categories', 'hide_empty' => true]);
    if (!is_wp_error($categories)) {
        $results['categories'] = array_map(function ($term) {
            return ['id' => $term->slug, 'name' => $term->name];
        }, $categories);
    }

    $formats = get_terms(['taxonomy' => 'formats', 'hide_empty' => true]);
    if (!is_wp_error($formats)) {
        $results['formats'] = array_map(function ($term) {
            return ['id' => $term->slug, 'name' => $term->name];
        }, $formats);
    }

    wp_send_json_success($results);
    wp_die();
}
add_action('wp_ajax_get_taxonomies_terms', 'natmota_get_taxonomies_terms');
add_action('wp_ajax_nopriv_get_taxonomies_terms', 'natmota_get_taxonomies_terms');

/**
 * Fonction AJAX pour filtrer les photos.
 */
add_action('wp_ajax_filter_photos', 'natmota_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'natmota_filter_photos');

function natmota_filter_photos() {
    error_log('Données AJAX reçues : ' . print_r($_POST, true));

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : null;
    $format   = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : null;
    $sort     = isset($_POST['sort']) && in_array($_POST['sort'], ['asc', 'desc'], true) ? $_POST['sort'] : 'DESC';

    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : -1, // Flexible
        'orderby'        => 'date',
        'order'          => isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : 'DESC',
        'tax_query'      => [],
    ];


    if ($category) {
        $args['tax_query'][] = [
            'taxonomy' => 'categories',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    if ($format) {
        $args['tax_query'][] = [
            'taxonomy' => 'formats',
            'field'    => 'slug',
            'terms'    => $format,
        ];
    }

    error_log('Arguments WP_Query : ' . print_r($args, true));

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <!-- Contenu du photo-block -->
            <div class="card-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('taille-photo-block');
                    } ?>
                </a>
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
                    <div class="icon-fullscreen"
                        data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'taille-hero'); ?>"
                        data-ref="<?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?>"
                        data-cat="<?php echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé'; ?>"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/Icon-fullscreen.png');">
                    </div>
                    <div class="icon-eye"
                        data-link="<?php the_permalink(); ?>"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/Icon-eye.png');">
                    </div>
                </div>
            </div>
            <?php
        }
        $html = ob_get_clean();
        wp_send_json_success(['html' => $html]);
    } else {
        wp_send_json_error(['message' => 'Aucune photo trouvée.']);
    }

    wp_die();
}
