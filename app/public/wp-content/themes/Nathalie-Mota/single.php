<!--Ce fichier est utilisé pour afficher le contenu d'un article individuel d'un blog.-->
<?php get_header(); ?>


<div class="main single">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="post">
                <div class="photo__info-description">
                    <h1><?php the_title(); ?></h1>
                    <ul class="post-info">

                        <li>RÉFÉRENCE : <?php the_field('reference'); ?></li>
                        <!-- Bloc pour afficher les catégories -->
                        <li>CATÉGORIE :
                            <?php
                            $id = get_the_ID(); // Récupère l'ID du post courant
                            $categories = get_the_terms($id, 'categorie'); // 'categorie' est le nom de ta taxonomie
                            if (!is_wp_error($categories)) {
                                echo implode(', ', wp_list_pluck($categories, 'name')); // Extrait les noms et les implémente
                            }
                            ?>
                        </li>



                        <!-- -----------------Bloc pour afficher les formats en taxonomy --------------------------------------->
                        <li>FORMAT :
                            <?php
                            // $id = get_the_ID(); // Récupère l'ID du post courant
                            $formats = get_the_terms($id, 'format'); // 'format' est le nom de ta taxonomie
                            if (!is_wp_error($formats)) {
                                echo implode(', ', wp_list_pluck($formats, 'name')); // wp_list_pluck Extrait les noms et les implémente
                            }
                            ?>
                        </li>


                        <li>TYPE : <?php the_field('type'); ?></li>
                        <?php
                        $annee_value = get_field('annee');
                        // Convertir le format de la date
                        $annee_value_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $annee_value)));
                        // Récupérer seulement l'année
                        $annee = date('Y', strtotime($annee_value_formatted));
                        ?>
                        <li>ANNÉE : <?php echo $annee; ?></li>



                    </ul>
                </div>

                <div class="contenair__img">
                    <?php

                    if (has_post_thumbnail()) {
                        the_post_thumbnail('large');
                    }
                    ?>

                </div>




            </article>
            <!------------------------------------------LE MINI SLIDE DES POSTES -->
            <div class="contenair__contact">
                <div class="photo__contact">
                    <p>Cette photo vous intéresse ? </p>

                    <button class="btn lien-contact-photo" id="lien-contact" data-photo-ref="<?php echo esc_attr(get_field('reference')); ?>">Contact</button>


                </div>
                <!-- <div class="thumbnail">-->

                <!--les slide des postes -->
                <div class="post-navigation">

                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post(); ?>

                    <!-- Conteneur pour les images des posts précédent et suivant -->
                    <div class="post-navigation-images">
                        <?php if (!empty($prev_post)) : ?>
                            <div class="prev-photo">
                                <!-- Lien et image de prévisualisation du post précédent -->
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" data-thumbnail="<?php echo get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>" alt="Image du post précédent">
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($next_post)) : ?>
                            <div class="next-photo">
                                <!-- Lien et image de prévisualisation du post suivant -->
                                <a href="<?php echo get_permalink($next_post->ID); ?>" data-thumbnail="<?php echo get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>" alt="Image du post suivant">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Conteneur pour les flèches de navigation -->
                    <div class="navigation-arrows">
                        <?php if (!empty($prev_post)) : ?>
                            <div class="navigation-arrow-prev">
                                <!-- Lien pour aller au post précédent -->
                                <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/precedent.svg" alt="Précédent">
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($next_post)) : ?>
                            <div class="navigation-arrow-next">
                                <!-- Lien pour aller au post suivant -->
                                <a href="<?php echo get_permalink($next_post->ID); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/suivant.svg" alt="Suivant">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- </div>-->
            </div>



        <?php endwhile; ?>
    <?php endif; ?>








    <?php
    // Récupérez les termes de la catégorie pour le post actuel
    $terms = wp_get_post_terms(get_the_ID(), 'categorie'); // 'category' est l'identifiant de la taxonomie

    if (!empty($terms)) {
        $term_ids = array_map(function ($term) {
            return $term->term_id;
        }, $terms);

        $args = array(
            'post_type' => 'photo', // 'photo' est l'identifiant de votre CPT
            'post_status' => 'publish',
            'posts_per_page' => 2, // Le nombre de photos à afficher
            'orderby' => 'rand', // Affichez les posts de manière aléatoire
            'post__not_in' => array(get_the_ID()), // Exclut le post actuel
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie', // Utilisez l'identifiant de votre taxonomie
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                ),
            ),
        );





        $related_posts = new WP_Query($args);
        if ($related_posts->have_posts()) {
            echo '<article>';
            echo ' <h2> Vous aimerez AUSSI </h2>';
            // echo '<div class="container-photos-meme-categorie">';

            echo '<div class="container-photos-meme-categorie">';
            while ($related_posts->have_posts()) {
                $related_posts->the_post();

                //get_template_part('template-parts/photo-content'); // Inclut le fichier de template partiel

                //echo '<div class="related-photo-container">';
                get_template_part('template-parts/photo-block'); // Inclut le fichier de template partiel
                //the_post_thumbnail('medium'); // Assurez-vous d'avoir des tailles d'image appropriées définies
                // echo '</div>';
                // the_title();
                //the_field('categorie');
                // echo '</div>';

            }
            echo '</div>';
            echo '</article>';
        }

        wp_reset_postdata(); // Réinitialiser les informations de la requête d'origine
    }






































    get_footer();
