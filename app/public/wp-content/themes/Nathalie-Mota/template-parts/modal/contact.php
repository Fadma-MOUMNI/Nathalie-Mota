<?php

/**
 * Modal de contact
 *
 * @package Nathalie Mota
 * @subpackage Modal de contact
 */
?>

<div class="popup_cover"><!--la div en trasparent -->

    <div class="popup-contact">
        <div class="popup-title__container">

            <!--le titre de contacte en double est ajouter en images dans le css  -->
            <div class="popup-title popup-title--first"></div>
            <div class="popup-title"></div>

        </div>
        <div class="popup-info">
            <div>
                <!--le short code de formulair ici-->
                <?php
                echo do_shortcode('[contact-form-7 id="6e70756" title="Contact form 1"]');
                ?>
            </div>
        </div>
    </div>






</div>