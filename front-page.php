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
        <div><?php
            // Chemin absolu du dossier contenant les images
            $directory = 'C:/Users/sophi/Bureau/OPENCLASSROOMS/local/nathaliemota/app/public/wp-content/uploads/2024/11';

            // Vérifier si le dossier existe
            if (is_dir($directory)) {
                // Lister uniquement les fichiers image valides
                $images = array_filter(scandir($directory), function ($file) use ($directory) {
                    $filePath = $directory . '/' . $file;
                    return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
                });

                // Filtrer les images qui font exactement 1440 pixels de large
                $filteredImages = array_filter($images, function ($file) use ($directory) {
                    $filePath = $directory . '/' . $file;

                    // Obtenir les dimensions de l'image
                    [$width, $height] = getimagesize($filePath);

                    // Retourner uniquement les images de 1440 pixels de large
                    return $width === 1440;
                });

                // Vérifier qu'il y a des images valides après filtrage
                if (!empty($filteredImages)) {
                    // Générer l'URL complète pour l'image aléatoire
                    $randomImage = $filteredImages[array_rand($filteredImages)];
                    $heroImage = get_site_url() . '/wp-content/uploads/2024/11/' . $randomImage;
                } else {
                    $heroImage = ''; // Aucun fichier valide trouvé
                    error_log('Aucune image de 1440px trouvée dans le dossier : ' . $directory);
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

                <div>
                    <select id="filter-sort" class="select2" onchange="applyFilters()">
                        <option value="" disabled selected>TRIER PAR</option>
                        <option value="desc">Du plus récent au plus ancien</option>
                        <option value="asc">Du plus ancien au plus récent</option>
                    </select>
                </div>
            </div>
        </div>

        </div>

        <div class="photos-block">
            <?php get_template_part('templates_parts/photo-block-front'); ?>
        </div>

        <div class="button-load-more">
            <!-- Bouton Charger plus -->
            <button id="load-more-photos" data-page="1">Charger plus</button>
        </div>

    </div>


<?php get_footer(); ?>
