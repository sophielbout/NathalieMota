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
    <header id="site-header" role="banner">
        <div class="header-container">
            <!-- Site logo -->
            <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
                <div class="site-logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>

            <!-- Site title -->
            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            </h1>

            <!-- Navigation -->
            <nav id="site-navigation" role="navigation">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                ) );
                ?>
            </nav>
        </div>
    </header>
