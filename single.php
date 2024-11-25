<?php
/**
 * Template for displaying all single posts
 *
 * @package NMota
 */

get_header(); // Appelle l'en-tête du thème
?>

<main class="wp-block-group">

    <div class="block-title-image">

        <div class="items-photo">
            <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();

                    // Champs personnalisés
                    $reference = get_field('reference') ?: 'Non spécifié';
                    $type = get_field('type') ?: 'Non spécifié';
                    $annees = get_field('annee') ?: 'Non spécifié';

                    // Taxonomies pour le CPT "Photo"
                    $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                    $formats = get_the_terms(get_the_ID(), 'portfolio_format');
            ?>
                <div>
                    <h2><?php the_title(); ?></h2>
                    <p class="info-photo">Référence : <?php echo esc_html($reference); ?></p>
                    <p class="info-photo">Type : <?php echo esc_html($type); ?></p>
                    <p class="info-photo">Année : <?php echo esc_html($annees); ?></p>
                    <p class="info-photo">Catégorie :
                        <?php
                        if ($categories && !is_wp_error($categories)) {
                            $category_names = wp_list_pluck($categories, 'name');
                            echo esc_html(implode(', ', $category_names));
                        } else {
                            echo 'Non classé';
                        }
                        ?>
                    </p>
                    <p class="info-photo">Format :
                        <?php
                        if ($formats && !is_wp_error($formats)) {
                            $format_names = wp_list_pluck($formats, 'name');
                            echo esc_html(implode(', ', $format_names));
                        } else {
                            echo 'Non classé';
                        }
                        ?>
                    </p>
                </div>
            <?php
                    endwhile;
                else :
                    echo '<p>Aucune publication trouvée.</p>';
                endif;
            ?>
        </div>

        <!-- Affiche l'image à la une si elle existe -->
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-featured-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="block-contact">
        <p>Cette photo vous intéresse ?</p>
        <a href="#myModal" class="open-modal">Contact</a>



    </div>

    <div class="block-like-to">
        <!-- Bloc Vous aimerez aussi -->
        <p>VOUS AIMEREZ AUSSI</p>
        <?php $uploads = '/wp-content/uploads'; ?>
        <div>
            <img src="<?php echo $uploads . '/2024/11/nathalie-0-300X200.jpeg'; ?>" alt="Nathalie 0">
            <img src="<?php echo $uploads . '/2024/11/nathalie-7-300X200.jpeg'; ?>" alt="Nathalie 2">
        </div>
    </div>

</main>

<?php get_footer(); // Appelle le pied de page du thème ?>
