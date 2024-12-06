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
            // Chemin absolu du dossier contenant les images
            $directory = 'C:/Users/sophi/Bureau/OPENCLASSROOMS/local/nathaliemota/app/public/wp-content/uploads/2024/11';

            // Vérifier si le dossier existe
            if (is_dir($directory)) {
                // Lister uniquement les fichiers image valides
                $images = array_filter(scandir($directory), function ($file) use ($directory) {
                    $filePath = $directory . '/' . $file;
                    return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
                });

                // Vérifier qu'il y a des images valides
                if (!empty($images)) {
                    // Générer l'URL complète pour l'image aléatoire
                    $randomImage = $images[array_rand($images)];
                    $heroImage = get_site_url() . '/wp-content/uploads/2024/11/' . $randomImage;
                } else {
                    $heroImage = ''; // Aucun fichier valide trouvé
                    error_log('Aucune image valide trouvée dans le dossier : ' . $directory);
                }
            } else {
                $heroImage = ''; // Dossier introuvable
                error_log('Le dossier des images n’existe pas : ' . $directory);
            }
            ?>

            <!-- HTML pour l'image hero -->
            <?php if (!empty($heroImage)): ?>
                <div class="hero-image" style="background-image: url('<?php echo esc_url($heroImage); ?>');">
                    <!-- Image superposée -->
                    <img src="http://nathaliemota.local/wp-content/themes/natmota/images/titre-header.png" alt="Titre Header" class="overlay-title">
                </div>
            <?php endif; ?>

        </div>

        <!-- Contenu principal de la page -->
        <div class="post-content">
            <?php get_template_part('templates_parts/photo-block'); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
