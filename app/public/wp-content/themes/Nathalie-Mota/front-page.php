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



        <?php get_template_part('template-parts/modal/hero'); ?>




        <!------------------------------------------------------------------------------------------------- Filtres -->

        <form action="" method="get">

            <div class="container_filter">
                <!-----------------------le champ de filtre catégorie -->
                <?php
                $categories = get_terms('categorie', array('hide_empty' => false));
                ?>
                <div class="container-category-format flexrow">
                    <div class="filter-category-format flexcolumn">

                        <select class="option-filter" name="categorie" id="category-filter">
                            <option value="" selected>CATÉGORIES</option>

                            <?php foreach ($categories as $categorie) : ?>
                                <option value="<?php echo esc_attr($categorie->slug); ?>">
                                    <?php echo esc_html($categorie->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-----------------------le champ de filtre formats  -->


                    <?php
                    $formats = get_terms('format', array('hide_empty' => false)); // Remplacez 'format' par votre taxonomie de format
                    ?>
                    <div class="filter-category-format flexcolumn ">

                        <select class="option-filter" name="format" id="format-filter">
                            <option value="" selected>Formats</option>
                            <option value=""></option>
                            <?php foreach ($formats as $format) : ?>
                                <option value="<?php echo esc_attr($format->slug); ?>">
                                    <?php echo esc_html($format->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                </div>




                <div class="filter-order flexcolumn ">







                    <select class="option-filter" name="order" id="order-filter">
                        <option value="" selected>TRIER PAR</option>
                        <option value=""></option>
                        <option value="DESC">Plus récentes</option>
                        <option value="ASC">Plus anciennes</option>
                    </select>























                </div>

            </div>








            <?php


            // Récupérer la valeur de la catégorie à partir des paramètres URL, ou la définir à vide si elle n'est pas définie.
            $category_filter = isset($_GET['categorie']) ? $_GET['categorie'] : '';
            // Récupérer la valeur du format à partir des paramètres URL, ou la définir à vide si elle n'est pas définie.
            $format_filter = isset($_GET['format']) ? $_GET['format'] : '';


            // Préparation des arguments de base pour la requête WP_Query.
            $args = array(
                'post_type' => 'photo', // Type de post personnalisé 'photo'.
                'posts_per_page' => 8, // Limite le nombre de posts à afficher à 8.
                'tax_query' => array( // Débute la construction d'une tax_query pour filtrer les posts par taxonomies.
                    'relation' => 'AND', // Si les deux filtres sont utilisés, un post doit correspondre aux deux conditions.
                ),
            );


            // Initialise un tableau pour construire la tax_query.
            $tax_query = array();



            // Ajouter un filtre par catégorie à la tax_query si une catégorie est définie.
            if (!empty($category_filter)) {
                $tax_query[] = array(
                    'taxonomy' => 'categorie', // Utilise la taxonomie 'category'.
                    'field'    => 'slug', // Utilise le 'slug' pour le matching des termes.
                    'terms'    => $category_filter, // Les termes à filtrer.
                );
            }

            // Ajouter un filtre par format à la tax_query si un format est défini.
            if (!empty($format_filter)) {
                $tax_query[] = array(
                    'taxonomy' => 'format', // Utilise la taxonomie 'format'.
                    'field'    => 'slug', // Utilise le 'slug' pour le matching des termes.
                    'terms'    => $format_filter, // Les termes à filtrer.
                );
            }

            // Ajouter la relation 'AND' à la tax_query si nécessaire.
            if (count($tax_query) > 1) {
                $tax_query['relation'] = 'AND';
            }

            // Si la tax_query est construite avec plusieurs filtres, les ajouter aux arguments de la WP_Query.
            if (!empty($tax_query)) {
                $args['tax_query'] = $tax_query;
            }







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

            // Réinitialise les données globales du post à leur état par défaut, ce qui est important après une requête personnalisée.
            wp_reset_postdata();
            ?>




            <div class="container-load-more">

                <button id="load-more">Charger plus</button>

            </div>
        </form>














    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer(); // Inclure le footer
?>