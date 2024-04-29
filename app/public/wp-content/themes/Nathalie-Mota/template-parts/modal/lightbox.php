<?php

/**
 * Modal lightbox
 *
 * @package Nathalie Mota
 * @subpackage Modal de lightbox
 */
?>
<?php

global $post;
// Obtenir les posts précédent et suivant
$prev_post = get_previous_post();
$next_post = get_next_post();

?>



<!-- Conteneur Lightbox -->
<div class="lightbox" id="lightboxModal">
    <span id="lightbox-close">&times;</span>
    <div id="contenair-img-info">

        <span class="navigation-arrow-prev-lightbox" onclick="prevlightbox()">←Précédent</span>
        <div class="contenair-img">
            <img id="lightbox-img" src="" alt="">
        </div>
        <span class="navigation-arrow-next-lightbox" onclick="nextlightbox()">Suivant →</span>

        <div id="lightbox-info">
            <p id="lightbox-reference"></p>
            <p id="lightbox-category"></p>
        </div>
    </div>
</div>
</div>