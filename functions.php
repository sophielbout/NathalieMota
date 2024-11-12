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
    wp_enqueue_style( 'nmota-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Custom JavaScript file
    wp_enqueue_script( 'nmota-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'nmota_enqueue_scripts' );
