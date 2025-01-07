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
    <header>
        <div class="site-header">

            <!-- Logo avec lien vers la page d’accueil -->
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo.png'); ?>"  class="logo" alt="<?php bloginfo('name'); ?>">
            </a>

            <!-- Menu classique Desktop -->
            <nav role="navigation" aria-label="<?php _e('Menu principal', 'NMota'); ?>" class="nav-container desktop-menu">
            <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'container'      => false, // Pas de <div> autour du <ul> de navigation
                    'menu_class'     => 'main-menu'
                ]);
            ?>
            </nav>

            <!-- Menu burger déroulant Mobile -->
            <div class="menu-overlay mobile-menu">
                <?php
                    wp_nav_menu([
                        'theme_location' => 'main-menu',
                        'container'      => false, // Pas de <div> autour du <ul> de navigation
                        'menu_class'     => 'mobile-menu-items'
                    ]);
                ?>
            </div>

            <!-- Icône burger -->
            <div class="burger-menu">
                <div></div>
                <div></div>
                <div></div>
            </div>

        </div>

    </header>
