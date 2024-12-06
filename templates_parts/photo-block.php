<?php
            // Récupération de la catégorie associée
            $current_categories = get_the_terms(get_the_ID(), 'categorie');

            if (!empty($current_categories) && !is_wp_error($current_categories)) {
                $current_category_slug = $current_categories[0]->slug;

                // Arguments de la requête
                $args = array(
                    'post_type' => 'photo',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categorie',
                            'field' => 'slug',
                            'terms' => $current_category_slug,
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
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $category_name = $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';

    if (has_post_thumbnail()) :
        ?>
        <div class="card-photo">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
                <!-- Conteneur pour l'effet de survol -->
                <div class="photo-overlay">
                    <span class="photo-reference"><?php echo esc_html($reference); ?></span>
                    <span class="photo-category"><?php echo esc_html($category_name); ?></span>
                </div>
            </a>
        </div>
        <?php
    endif;

endwhile;




                else :
                    echo '<p>Aucune image disponible pour cette catégorie.</p>';
                endif;

                // Réinitialiser la requête principale
                wp_reset_postdata();
            } else {
                echo '<p>Aucune catégorie associée à cet article.</p>';
            }
            ?>