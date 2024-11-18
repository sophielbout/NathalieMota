<?php
/**
 * Functions and definitions for NMota Theme
 *
 * @package NMota
 * @since 1.0.0
 */

/**
 * Enqueues the main stylesheet and any JavaScript files.
 */
function nmota_enqueue_scripts() {

    // Main stylesheet
    wp_enqueue_style( 'natmota-style', get_template_directory_uri() . '/style.css', array(), time() );


    // Custom JavaScript file
    wp_enqueue_script( 'natmota-scripts', get_template_directory_uri() . '/js/scripts.js', array(), time(), true );
}
add_action( 'wp_enqueue_scripts', 'nmota_enqueue_scripts' );


function register_my_menu() {
    register_nav_menu('main-menu', __( 'Menu principal', 'nmota' ));
    register_nav_menu('footer-menu', __( 'Menu de pied de page', 'nmota' ));
}
add_action( 'after_setup_theme', 'register_my_menu' );
