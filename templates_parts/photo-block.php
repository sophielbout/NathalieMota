<?php
// Avant de générer un bloc photo, récupère le titre du post
$post_title = get_the_title() ?: 'Titre non disponible';
?>
<div class="photo-block-container">
    <div class="card-photo">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) {
                the_post_thumbnail('taille-photo-block');
            } ?>
        </a>
        <div class="photo-overlay">
            <span class="photo-reference">
                <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée'); ?>
            </span>
            <span class="photo-category">
                <?php
                $categories = get_the_terms(get_the_ID(), 'categories');
                echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';
                ?>
            </span>
            <div class="icon-fullscreen"
                data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'taille-hero'); ?>"
                data-ref="<?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?>"
                data-cat="<?php echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé'; ?>"
                data-title="<?php echo esc_attr($post_title); ?>"
                style="background-image: url('http://nathaliemota.local/wp-content/themes/natmota/images/Icon-fullscreen.png');">
            </div>

            <div class="icon-eye"
                data-link="<?php the_permalink(); ?>"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/Icon-eye.png');">
            </div>
        </div>
    </div>
</div>