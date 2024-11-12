<?php
/**
 * Template for displaying all single posts
 *
 * @package NMota
 */

get_header(); // Appelle l'en-tête du thème
?>

<main class="wp-block-group alignfull">
    <div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--40);padding-top:var(--wp--preset--spacing--50)">

        <!-- Affiche l'image à la une si elle existe -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-featured-image" style="margin-bottom: var(--wp--preset--spacing--40);">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>

        <div class="wp-block-group" style="padding-top:0;padding-bottom:0">
            <!-- Affiche le titre de l'article -->
            <h1 class="post-title" style="font-size: var(--wp--preset--font-size--x-large);"><?php the_title(); ?></h1>

            <!-- Affiche les métadonnées de l'article (auteur, date, etc.) -->
            <div class="post-meta">
                <?php echo get_template_part( 'template-parts/post-meta' ); ?>
            </div>
        </div>
    </div>

    <!-- Affiche le contenu de l'article -->
    <div class="post-content alignfull">
        <?php the_content(); ?>
    </div>

    <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--50)">

        <!-- Affiche les tags de l'article sous forme de liste -->
        <div class="post-terms is-style-pill">
            <?php the_tags( '', ' ', '' ); ?>
        </div>

        <div class="wp-block-group">
            <div style="height:var(--wp--preset--spacing--40)" aria-hidden="true" class="wp-block-spacer"></div>

            <hr class="wp-block-separator has-text-color has-contrast-3-color has-alpha-channel-opacity has-contrast-3-background-color has-background is-style-wide" style="margin-bottom:var(--wp--preset--spacing--40)"/>

            <!-- Affiche la section des commentaires -->
            <?php comments_template(); ?>

            <!-- Affiche la navigation des articles -->
            <div class="post-navigation">
                <?php the_post_navigation(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); // Appelle le pied de page du thème ?>
