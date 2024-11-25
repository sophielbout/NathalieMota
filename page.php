<?php
/**
 * Template for displaying all pages
 *
 * @package NMota
 */

get_header(); // Appelle l'en-tête du thème
?>

<main class="wp-block-group">
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
        <?php
            // Template portfolio.php
            get_template_part('templates_part/portfolio');
            ?>

    </div>
</main>

<?php get_footer(); ?>
