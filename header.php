<?php
/**
 * Header template for the NMota theme
 *
 * This file includes the <head> section and starts the HTML structure for the site,
 * including the logo, navigation, and any other header elements.
 *
 * @package NMota
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="site-wrapper">
        <!-- Début du contenu du site -->

    <header class="site-header">

        <!-- Logo avec lien vers la page d’accueil -->
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo.png'); ?>"  class="logo" alt="<?php bloginfo('name'); ?>">
        </a>

        <!-- Conteneur du menu -->
        <nav role="navigation" aria-label="<?php _e('Menu principal', 'NMota'); ?>" class="nav-container">
            <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'container'      => false, // Pas de <div> autour du <ul> de navigation
                    'menu_class'     => 'main-menu'
                ]);
            ?>
        </nav>
</header>

</div>

</header>
