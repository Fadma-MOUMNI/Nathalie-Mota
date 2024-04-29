<?php

/**
 * Modal photo-block
 *
 * @package Nathalie Mota
 * @subpackage Modal de photo-block
 */
?>

<?php
// Obtenir les posts précédent et suivant
$prev_post = get_previous_post();
$next_post = get_next_post();
//$image_id = get_post_meta($id, 'photos', true);
// Obtenir le lien permanent du post
$post_link = get_permalink();
//$categorie = get_field('categorie');
$id = get_the_ID(); // Récupère l'ID du post courant
// Récupérer les termes de la taxonomie 'categorie' pour le post courant
$categories = get_the_terms($id, 'categorie'); // (get_the_terms) pour les les taxonomies,
$reference = get_field('reference');
$photo_thumbnail = get_the_post_thumbnail(null, 'large');
$image_url = esc_attr(get_the_post_thumbnail_url(get_the_ID(), 'full'));

?>

<div class="photo">

    <?php
    echo $photo_thumbnail;
    ?>
    </a>
    <div class="overlay">
        <div class="container-fullscreen-icon" onclick="openLightbox('<?php echo $image_url; ?>', '<?php echo esc_attr($reference); ?>', '<?php echo esc_attr($categories[0]->name); ?>', this)">

            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/fullscreen.png" alt="<?php esc_attr_e('Plein écran', 'text-domain'); ?>">
        </div>
        <div class="container-eye-icon">
            <a href="<?php echo esc_url($post_link); ?>" class="eye-icon">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/eye.png" alt="<?php esc_attr_e('Icône œil', 'text-domain'); ?>" />
            </a>
        </div>
        <div class="container-catego-reference">
            <div>
                <?php if (!empty($reference)) : ?><!--Vérifie si la référence n'est pas vide-->
                    <!--Affiche la référence dans un paragraphe-->
                    <!-- esc_html est utilisé pour la sécurité, pour éviter les problèmes de sécurité comme XSS-->
                    <p> <?php echo esc_html($reference); ?></p>
                <?php endif; ?>

                </p>
            </div>
            <div>
                <!--- (!empty($categories)): vérifie qu'il y a bien des catégories à affiche--->
                <?php if (!empty($categories)) : ?>
                    <!-- Comme chaque post n'a qu'une seule catégorie, accédez directement au premier élément
                     et Affichez le nom de la catégorie dans un paragraphe-->
                    <p><?php echo esc_html($categories[0]->name); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>