<?php
/**
 * Footer template for the NMota theme
 *
 * This file closes the main content and includes any footer elements.
 *
 * @package NMota
 * @since 1.0.0
 */
?>

</main>

<footer role="contentinfo">
    <div class="footer-container">
        <nav class="footer-nav" role="navigation" aria-label="<?php _e('Menu de pied de page', 'NMota'); ?>">
            <?php
                wp_nav_menu([
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'footer-menu',
                ]);
            ?>
        </nav>
    </div>
</footer>

<!-- Modale menu et bouton -->
<?php get_template_part( 'templates_parts/modale' ); ?>

<!-- Lightbox -->
<?php get_template_part( 'templates_parts/lightbox' ); ?>

</div> <!-- Fin de .site-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
