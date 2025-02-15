<?php
/**
 * Template for displaying all single posts
 *
 * @package NMota
 */

get_header();
?>

<main class="main-single">

    <div class="container-single">

        <div class="block-image-and-info">
            <!-- Bloc contenant les items et l'image côte à côte -->
            <div class="block-title-image">
                <div class="items-photo">
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        // Initialisation des variables
                        $reference = get_post_meta(get_the_ID(), 'reference', true) ?: 'Non renseignée';
                        $type = get_post_meta(get_the_ID(), 'type', true) ?: 'Non renseigné';
                        $annees = get_post_meta(get_the_ID(), 'annee', true) ?: 'Non renseignée';
                        $categories = get_the_terms(get_the_ID(), 'categories');
                        $formats = get_the_terms(get_the_ID(), 'formats');
                    ?>
                        <div>
                            <h2><?php the_title(); ?></h2>
                            <!-- Référence -->
                            <p class="info-photo">Référence : <?php echo esc_html($reference); ?></p>
                            <!-- Catégorie -->
                            <p class="info-photo">Catégorie :
                                <?php
                                echo $categories && !is_wp_error($categories)
                                    ? esc_html(implode(', ', wp_list_pluck($categories, 'name')))
                                    : 'Non classé';
                                ?>
                            </p>
                            <!-- Formats -->
                            <p class="info-photo">Format :
                                <?php
                                echo $formats && !is_wp_error($formats)
                                    ? esc_html(implode(', ', wp_list_pluck($formats, 'name')))
                                    : 'Non classé';
                                ?>
                            </p>
                            <!-- Type -->
                            <p class="info-photo">Type : <?php echo esc_html($type); ?></p>
                            <!-- Année -->
                            <p class="info-photo">Année : <?php echo esc_html(get_the_date('Y')); ?></p>
                        </div>
                    <?php endwhile; endif; ?>
                </div>

                <div class="featured-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-featured-image">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bloc contact et navigation -->
            <div class="block-contact">
                <div class="contact-button">
                    <p>Cette photo vous intéresse ?</p>
                    <a href="#myModal2" class="open-modal" data-ref="<?php echo esc_attr(get_field('reference', get_the_ID())); ?>">Contact</a>
                </div>

                <div class="navigation-links">
                    <!-- Flèche gauche -->
                    <?php
                    $prev_post = get_previous_post();
                    if (empty($prev_post)) {
                        // Aucun article précédent, récupérer le dernier article
                        $prev_post = get_posts([
                            'post_type' => 'photo',
                            'posts_per_page' => 1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ]);
                        $prev_post = !empty($prev_post) ? $prev_post[0] : null;
                    }

                    if (!empty($prev_post)) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="nav-arrow prev-arrow">
                            <img src="http://nathaliemota.local/wp-content/themes/natmota/images/Line-6.png" alt="Précédent">
                            <div class="miniature" style="display: none;">
                                <?php echo get_the_post_thumbnail($prev_post->ID, [81, 79]); ?>
                            </div>
                        </a>
                    <?php endif; ?>

                    <!-- Flèche droite -->
                    <?php
                    $next_post = get_next_post();
                    if (empty($next_post)) {
                        // Aucun article suivant, récupérer le premier article
                        $next_post = get_posts([
                            'post_type' => 'photo',
                            'posts_per_page' => 1,
                            'orderby' => 'date',
                            'order' => 'ASC',
                        ]);
                        $next_post = !empty($next_post) ? $next_post[0] : null;
                    }

                    if (!empty($next_post)) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="nav-arrow next-arrow">
                            <img src="http://nathaliemota.local/wp-content/themes/natmota/images/Line-7.png" alt="Suivant">
                            <div class="miniature" style="display: none;">
                                <?php echo get_the_post_thumbnail($next_post->ID, [81, 79]); ?>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bloc Vous aimerez aussi -->
            <div class="block-like-to">
                <div id="like-too">VOUS AIMEREZ AUSSI</div>

                <div class="photos-block">
                    <?php
                    $args = [
                        'post_type'      => 'photo', // Type de post "photo"
                        'posts_per_page' => 2, // Limite à 2 photos
                        'orderby'        => 'rand', // Affiche les posts de manière aléatoire
                        'post__not_in'   => [get_the_ID()], // Exclut le post actuel
                        'tax_query'      => [ // Requête pour la taxonomie "categories"
                            [
                                'taxonomy' => 'categories',
                                'field'    => 'term_id',
                                'terms'    => wp_get_post_terms(get_the_ID(), 'categories', ['fields' => 'ids']),
                            ],
                        ],
                    ];

                    $query = new WP_Query($args);

                    if ($query->have_posts()) : ?>
                        <div class="photoblock-gallery">
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <?php get_template_part('templates_parts/photo-block'); // Insère un seul bloc ?>
                            <?php endwhile; ?>
                        </div>
                    <?php else : ?>
                        <p>Aucune photo trouvée.</p>
                    <?php endif;

                    wp_reset_postdata(); // Réinitialise la requête WP
                    ?>
                </div>
            </div>

        </div>
    </div>
</main>

<?php get_footer(); // Appelle le pied de page du thème ?>
