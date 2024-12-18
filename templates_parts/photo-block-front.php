<div class="photoblock-gallery">
    <?php
    // Arguments par défaut pour récupérer les photos
    $args = [
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    // Récupérer les filtres via `$_POST` si AJAX
    if (!empty($_POST['category'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'categories',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['category']),
        ];
    }
    if (!empty($_POST['format'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'formats',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['format']),
        ];
    }
    if (!empty($_POST['sort'])) {
        $args['order'] = sanitize_text_field($_POST['sort']);
    }

    // WP_Query pour récupérer les photos
    $query = new WP_Query($args);

    // Afficher les résultats
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="card-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('taille-featured-image');
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
                    <!-- Icône Lightbox -->
                    <div class="icon-fullscreen"
                        data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                        data-ref="<?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?>"
                        data-cat="<?php echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé'; ?>"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/Icon-fullscreen.png');">
                    </div>
                    <!-- Icône Single -->
                    <div class="icon-eye"
                        data-link="<?php the_permalink(); ?>"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/Icon-eye.png');">
                    </div>
                </div>
            </div>


            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>
</div>
