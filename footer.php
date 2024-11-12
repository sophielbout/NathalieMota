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

<?php get_template_part( 'templates-part/modale' ); ?>

    <footer id="site-footer" role="contentinfo">
        <div class="footer-container">
            <!-- Footer content, like copyright or navigation -->
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. Tous droits réservés.</p>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_id'        => 'footer-menu',
            ) );
            ?>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
