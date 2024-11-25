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
            'parent-style', // Identifiant du style parent
            get_template_directory_uri() . '/style.css' // Chemin vers le style du thème parent
        );

        // Charger le CSS compilé par Sass, mais uniquement sur le front-end
        if (file_exists(get_stylesheet_directory() . '/css/main.css')) {
            wp_enqueue_style(
                'natmota-main-style', // Identifiant unique pour le style enfant
                get_stylesheet_directory_uri() . '/css/main.css', // Chemin vers le fichier CSS compilé
                array('parent-style'), // Dépendance : charge d'abord le style parent
                filemtime(get_stylesheet_directory() . '/css/main.css'), // Version dynamique en fonction de la dernière modification
                'all' // Applique ce style à tous les types de médias
            );
        }
    }

add_action('wp_enqueue_scripts', 'natmota_enqueue_assets');


    // Charger le fichier JS pour la modale (ou tout JS personnalisé)
    wp_enqueue_script(
        'natmota-modal-script',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array(),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'natmota_enqueue_assets');

/**
 * Registers navigation menus.
 */
function natmota_register_menus() {
    register_nav_menus(array(
        'main-menu' => __( 'Menu principal', 'nmota' ),
        'footer-menu' => __( 'Menu de pied de page', 'nmota' ),
    ));
}
add_action('after_setup_theme', 'natmota_register_menus');



function associate_taxonomies_with_photo() {
    register_taxonomy_for_object_type('categorie', 'Photo');
    register_taxonomy_for_object_type('format', 'Photo');
}
add_action('init', 'associate_taxonomies_with_photo');

function enqueue_theme_scripts() {
    wp_enqueue_script(
        'theme-scripts',
        get_template_directory_uri() . '/js/script.js', // Chemin vers votre script
        array(),
        null,
        true // Charge dans le footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');
