<?php
/**
 * Template part for displaying the contact modal
 *
 * @package NMota
 */
?>

<!-- templates-part/modale.php -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/contact-header.png" alt="Hero Image" class="modal-hero">
        <?php echo do_shortcode('[contact-form-7 id="a40afe1" title="Contact"]'); ?>
        <button class="close">X</button>
    </div>
</div>
