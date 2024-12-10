<?php
// Arguments pour la requête WP_Query
$args = array(
    'post_type' => 'photo',      // Type de contenu personnalisé
    'posts_per_page' => 8,       // Limite : 4 lignes de 2 photos
    'orderby' => 'date',         // Tri par date
    'order' => 'DESC',           // Ordre décroissant
);

// Nouvelle instance WP_Query
$query = new WP_Query($args);

// Vérification des résultats
if ($query->have_posts()) : ?>
    <div class="photoblock-gallery">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="card-photo">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    // Affichage de la miniature
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('medium'); // Taille moyenne
                    }
                    ?>
                    <!-- Overlay pour l'effet au survol -->
                    <div class="photo-overlay">
                        <span class="photo-reference">
                            <?php
                            // Récupérer la référence
                            echo esc_html(get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée');
                            ?>
                        </span>
                        <span class="photo-category">
                            <?php
                            // Récupérer et afficher la catégorie associée
                            $categories = get_the_terms(get_the_ID(), 'categories');
                            echo $categories && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'Non classé';
                            ?>
                        </span>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php
else :
    echo '<p>Aucune photo trouvée.</p>';
endif;

// Réinitialiser les données globales de la requête
wp_reset_postdata();
?>
