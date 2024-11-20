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
    // Charger le fichier JS pour la modale (ou tout JS personnalisé)
    wp_enqueue_script(
        'natmota-modal-script',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array(),
        null,
        true
    );
}
    // Charger le style du thème parent
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // Charger le CSS compilé par Sass (si présent)
    if (file_exists(get_stylesheet_directory() . '/css/main.css')) {
        wp_enqueue_style(
            'natmota-main-style',
            get_stylesheet_directory_uri() . '/css/main.css',
            array('parent-style'),
            filemtime(get_stylesheet_directory() . '/css/main.css'),
            'all'
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
