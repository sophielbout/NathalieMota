<?php
/**
 * Template for displaying all pages
 *
 * @package NMota
 */

get_header(); ?>

<main id="main" class="site-main wrapper">
    <div class="container content">
        <?php
        // Start the loop
        if (have_posts()) :
            while (have_posts()) :
                the_post();

                // Display the title (H1)
                echo '<h1>' . get_the_title() . '</h1>';

                // Display the page content
                the_content();

            endwhile;
        else :
            // Optionally, add a message for when no content is found
            echo '<p>Aucun contenu disponible.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
