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
    // Vérifier si le paramètre "page" est bien transmis
    if (!isset($_POST['page']) || !is_numeric($_POST['page'])) {
        wp_send_json_error(array('message' => 'Paramètre "page" manquant ou invalide.'));
    }

    $paged = intval($_POST['page']); // Page demandée
    if ($paged < 1) $paged = 1; // Sécurité pour éviter des valeurs négatives

    // Arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8, // Nombre de photos par page
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    // Vérifier si des posts existent
    if ($query->have_posts()) {
        ob_start(); // Commencer à capturer la sortie

        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="card-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="photo-overlay">
                        <span class="photo-reference">
                            <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée'); ?>
                        </span>
                        <span class="photo-category">
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'categorie');
                            echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';
                            ?>
                        </span>
                    </div>
                </a>
            </div>
            <?php
        endwhile;

        $content = ob_get_clean(); // Récupérer le contenu capturé

        // Vérifier s'il reste d'autres pages à charger
        $has_more = $paged < $query->max_num_pages;

        wp_send_json_success(array(
            'content' => $content,
            'has_more' => $has_more, // Indiquer s'il reste des photos
        ));
    } else {
        wp_send_json_error(array('message' => 'Aucune photo trouvée.'));
    }

    wp_die(); // Toujours arrêter l'exécution PHP après une réponse AJAX
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
