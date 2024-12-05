<?php
/**
 * Template for the front page
 *
 * This is the template for the static front page when set in the WordPress admin.
 *
 * @package NMota
 * @since 1.0.0
 */
get_header(); ?>


<main>
    <div class="fp-block-group">
        <div>
            <!-- Affiche l'image à la une si elle existe -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-featured-image" style="margin-bottom: var(--wp--preset--spacing--40);">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Image Hero -->
            <div class="image-hero">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/image-hero.png" alt="Hero Image">
            </div>

        <!-- Contenu principal de la page -->
        <div class="post-content">

        <?php get_template_part( 'templates_parts/photo-block' ); ?>

        </div>

    </div>

<?php get_footer(); ?>
