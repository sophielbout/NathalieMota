<?php
/**
 * Template for the front page
 *
 * This is the template for the static front page when set in the WordPress admin.
 *
 * @package NMota
 * @since 1.0.0
 */

get_header();
?>

<main class="main-front-page">
    <div class="fp-block-group">
        <div>
            <?php
            // Récupérer les posts de type "photo"
            $posts = get_posts([
                'post_type'      => 'photo',
                'posts_per_page' => -1, // Tous les posts
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);

            $images = [];

            // Parcourir les posts pour récupérer uniquement les miniatures de taille 'taille-hero'
            foreach ($posts as $post) {
                $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'taille-hero'); // Taille spécifique
                if ($thumbnail_url) {
                    $images[] = $thumbnail_url; // Ajouter l'URL à la liste
                }
            }

            // Sélectionner une image aléatoire
            $heroImage = !empty($images) ? $images[array_rand($images)] : '';
            ?>

            <!-- HTML pour l'image hero -->
            <div class="hero-image" style="background-image: url('http://nathaliemota.local/wp-content/uploads/2024/11/nathalie-0-scaled-e1733493677813.jpeg');">
                <img src="http://nathaliemota.local/wp-content/themes/natmota/images/titre-header.png" alt="Titre Header" class="overlay-title">
            </div>

        </div>

        <div class="photo-filters">
            <div class="filters">
                <div id="left-filters">
                    <select id="filter-categories" class="select2" onchange="applyFilters()">
                        <option value="" disabled selected>CATÉGORIES</option>
                        <?php
                        $categories = get_terms(['taxonomy' => 'categories', 'hide_empty' => true]);
                        foreach ($categories as $category) {
                            echo "<option value='{$category->slug}'>{$category->name}</option>";
                        }
                        ?>
                    </select>

                    <select id="filter-formats" class="select2" onchange="applyFilters()">
                        <option value="" disabled selected>FORMATS</option>
                        <?php
                        $formats = get_terms(['taxonomy' => 'formats', 'hide_empty' => true]);
                        foreach ($formats as $format) {
                            echo "<option value='{$format->slug}'>{$format->name}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div id="right-filters">
                    <select id="filter-sort" class="select2" onchange="applyFilters()">
                        <option value="" disabled selected>TRIER PAR</option>
                        <option value="desc">Du plus récent au plus ancien</option>
                        <option value="asc">Du plus ancien au plus récent</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="photos-block">
            <?php
            // Définir les arguments pour récupérer les photos
            $args = [
                'post_type'      => 'photo',
                'posts_per_page' => 8,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];

            // Log pour vérifier les arguments passés à WP_Query
            error_log('Arguments utilisés pour WP_Query dans front-page : ' . print_r($args, true));

            // Créer la requête WP_Query
            $query = new WP_Query($args);

            if ($query->have_posts()) : ?>
                <div class="photoblock-gallery">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <?php get_template_part('templates_parts/photo-block'); ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p>Aucune photo trouvée.</p>
            <?php endif;

            // Réinitialiser les données de la requête WP
            wp_reset_postdata();
            ?>
        </div>

        <div class="button-load-more">
            <button id="load-more-photos" data-page="1">Charger plus</button>
        </div>
    </div>
</main>

<?php get_footer(); ?>
