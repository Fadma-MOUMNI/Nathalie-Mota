<?php

/**
 * page d'accueil
 *
 * @package Nathalie Mota
 * @subpackage page d'accueil
 */
?>




<?php
get_header(); // Inclure le header
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">


        <!------------------------------------------------------la banniere -->

        <?php get_template_part('template-parts/hero/hero'); ?>


        <!------------------------------------------------------------------------------ Filtres ---------------------------------->
        <?php
        // Récupérer toutes les catégories disponibles.
        $categories = get_terms('categorie');
        // Récupérer tous les formats disponibles.
        $formats = get_terms('format');
        ?>
        <form action="" method="get">

            <div class="container_filter">
                <!---------------------------le champ de filtre catégorie ---------------------------->

                <div class="container-category-format flexrow">
                    <div class="filter-category-format flexcolumn">

                        <select class="option-filter" name="categorie" id="category-filter">
                            <option value="" selected>CATÉGORIES</option>

                            <?php foreach ($categories as $categorie) : ?>
                                <!-- Lorsque une catégorie est sélectionnée dans le formulaire, la valeur 'slug' de cette catégorie 
                                est envoyée au serveur. PHP récupère ensuite cette valeur et l'utilise dans 'tax_query' pour 
                                 filtrer les posts correspondants. -->
                                <option value="<?php echo esc_attr($categorie->slug); ?>">
                                    <?php echo esc_html($categorie->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-----------------------le champ de filtre formats  ---------------------------->

                    <div class="filter-category-format flexcolumn ">

                        <select class="option-filter" name="format" id="format-filter">
                            <option value="" selected>Formats</option>

                            <?php foreach ($formats as $format) : ?>
                                <option value="<?php echo esc_attr($format->slug); ?>">
                                    <?php echo esc_html($format->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                </div>


                <!-----------------------le champ de filtre par ordre  ----------------------------->

                <div class="filter-order flexcolumn ">


                    <select class="option-filter" name="order" id="order-filter">
                        <div class="liste-options">
                            <option value="" selected>TRIER PAR</option>

                            <option value="DESC">Les plus récentes</option>
                            <option value="ASC">Les plus anciennes</option>
                        </div>
                    </select>
                </div>

            </div>


            <!-------------------------------------------------------------L'affichage des photos du catalogue---------------------->
            <?php


            // Préparation des arguments de base pour la requête WP_Query.
            $args = array(
                'post_type' => 'photo', // Type de post personnalisé 'photo'.
                'posts_per_page' => 8, // Limite le nombre de posts à afficher à 8.

            );

            // Exécute la requête avec les arguments définis.
            $photo_query = new WP_Query($args);

            // Boucle sur les posts retournés par la requête.
            if ($photo_query->have_posts()) {
                echo '<div class="container-catalogue">';

                echo '<div class="catalogue-photos">';
                while ($photo_query->have_posts()) {
                    $photo_query->the_post(); // Itère sur les posts.
                    get_template_part('template-parts/photo-block'); // Inclut le fichier de template partiel
                }
                echo '</div>';
                echo '</div>';
            }

            // Réinitialise les données globales du post à leur état par défaut.
            wp_reset_postdata();

            ?>

            <!---------------------------------------------Le bouton charger plus ------------------------------->
            <div class="container-load-more">

                <button id="load-more" type="button">Charger plus</button>


            </div>
        </form>

    </main>
</div>

<?php
get_footer(); // Inclure le footer
?>