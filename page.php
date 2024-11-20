<?php
/**
 * Template for displaying all pages
 *
 * @package NMota
 */

get_header(); // Appelle l'en-tête du thème
?>

<main class="wp-block-group">
    <div class="wp-block-group">
        <div style="height:var(--wp--preset--spacing--50)" aria-hidden="true" class="wp-block-spacer"></div>

        <!-- Affiche le titre de la page -->


        <div style="margin-top:0;margin-bottom:0;height:var(--wp--preset--spacing--30)" aria-hidden="true" class="wp-block-spacer"></div>

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
        <?php the_content(); ?>
    </div>
</main>

<?php get_footer(); // Appelle le pied de page du thème ?>
