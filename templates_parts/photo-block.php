<?php
// Récupération de la catégorie associée
$current_categories = get_the_terms(get_the_ID(), 'categories');

// Vérification que des catégories existent et récupération du slug
if (!empty($current_categories) && !is_wp_error($current_categories)) {
    $current_category_slug = $current_categories[0]->slug; // Récupère le slug de la première catégorie

    // Arguments de la requête
    $args = array(
        'post_type' => 'photo',
        'tax_query' => array(
            array(
                'taxonomy' => 'categories',
                'field' => 'slug',
                'terms' => $current_category_slug, // Utilise le slug récupéré
            ),
        ),
        'posts_per_page' => 2,
        'orderby' => 'rand',
    );

    // Requête WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();

            // Récupérer les données dynamiques
            $reference = get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée';
            $categories = get_the_terms(get_the_ID(), 'categories');
            $category_name = $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';

            if (has_post_thumbnail()) :
                ?>
                <div class="card-photo">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('taille-featured-image'); ?>
                    </a>
                    <div class="photo-overlay">
                        <span class="photo-reference">
                            <?php echo esc_html($reference); ?>
                        </span>
                        <span class="photo-category">
                            <?php echo $category_name; ?>
                        </span>
                        <!-- Icône Lightbox -->
                        <div class="icon-fullscreen"
                            data-src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
                            data-ref="<?php echo esc_html($reference); ?>"
                            data-cat="<?php echo $category_name; ?>"
                            style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/images/Icon-fullscreen.png');">
                        </div>
                        <!-- Icône Single -->
                        <div class="icon-eye"
                            data-link="<?php the_permalink(); ?>"
                            style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/images/Icon-eye.png');">
                        </div>
                    </div>
                </div>
                <?php
            endif;

        endwhile;
        wp_reset_postdata(); // Toujours réinitialiser la requête après un WP_Query
    else :
        echo '<p>Aucune image disponible pour cette catégorie.</p>';
    endif;
} else {
    echo '<p>Aucune catégorie associée à cet article.</p>';
}
?>
