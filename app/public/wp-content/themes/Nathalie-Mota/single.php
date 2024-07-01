<!--Ce fichier est utilisé pour afficher le contenu d'un article individuel d'un blog.-->
<?php get_header(); ?>

<?
$reference = get_field('reference'); // (get_field) pour les champs personnalisés
$type = get_field('type');
$annee_value = get_field('annee');
$id = get_the_ID(); // Récupère l'ID du post courant
// Récupérer les termes de la taxonomie 'categorie' pour le post courant
$categories = get_the_terms($id, 'categorie'); // (get_the_terms) pour les les taxonomies,
// Récupérer les termes de la taxonomie 'format' pour le post courant
$formats = get_the_terms($id, 'format');


?>


<div class="main single">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="post">
                <div class="photo__info-description">
                    <h1><?php the_title(); ?></h1>
                    <ul class="post-info">
                        <!--------------------------------------------- la reference du poste courant   -------------------->
                        <li>RÉFÉRENCE : <?php echo esc_html($reference); ?></li>

                        <!--------------------------------------------- la catégorie du poste courant( un taxonomie)  -------------------->


                        <!--- (!empty($categories)): vérifie qu'il y a bien des catégories à affiche--->
                        <?php if (!empty($categories)) : ?>
                            <!-- Comme chaque post n'a qu'une seule catégorie, accédez directement au premier élément
                     et Affichez le nom de la catégorie dans un paragraphe-->
                            <li>CATÉGORIE : <?php echo esc_html($categories[0]->name); ?></li>
                        <?php endif; ?>




                        <!-- -----------------le format du poste courant(un taxonomie)--------------------------------------->
                        <!--- (!empty($categories)): vérifie qu'il y a bien des catégories à affiche--->
                        <?php if (!empty($formats)) : ?>
                            <!-- Comme chaque post n'a qu'une seule catégorie, accédez directement au premier élément
                           et Affichez le nom de la catégorie dans un paragraphe-->
                            <li> FORMAT : <?php echo esc_html($formats[0]->name); ?></li>
                        <?php endif; ?>

                        <!-------------------------------------------TYPE----------------------------------------------------------->
                        <li>TYPE : <?php echo esc_html($type); ?></li>

                        <!-------------------------------------------ANNEE----------------------------------------------------------->

                        <?php

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

            <div class="contenair__contact">
                <div class="photo__contact">
                    <p>Cette photo vous intéresse ? </p>
                    <!----------------------------------------- Bouton avec reference -->
                    <!--  (data-photo-ref)stocke la référence de la photo pour utilisation dans le formulaire de contact(la suite dans le fichier (js)  -->
                    <button class="btn lien-contact-photo" id="lien-contact" data-photo-ref="<?php echo esc_attr($reference); ?>">Contact</button>

                </div>


                <!-------------------------------------------------------------------------------------------le slide des postes -->
                <div class="post-navigation">

                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post(); ?>

                    <!-- Conteneur pour les images des posts précédent et suivant -->
                    <div class="post-navigation-images">

                        <?php if (!empty($prev_post)) : ?> <!-- vérifie si l'article précédent(la variable ($prev_post) ) n'est pas vide  -->
                            <!-- l'image de prévisualisation du post précédent -->
                            <div class="prev-photo">

                                <!-- Récupère l'URL de l'image d'article précédent en utilisant son ID unique avec la fonction get_the_post_thumbnail_url() -->
                                <img src="<?php echo get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>" alt="Image du post précédent">

                            </div>
                        <?php endif; ?>

                        <?php if (!empty($next_post)) : ?><!-- vérifie si l'article précédent(la variable ($next_post) ) n'est pas vide  -->
                            <!--l'image de prévisualisation du post suivant -->
                            <div class="next-photo">

                                <!-- Récupère l'URL de l'image d'article suivant en utilisant son ID unique avec la fonction get_the_post_thumbnail_url() -->
                                <img src="<?php echo get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>" alt="Image du post suivant">

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Conteneur pour les flèches de navigation -->
                    <div class="navigation-arrows">
                        <?php if (!empty($prev_post)) : ?>
                            <div class="navigation-arrow-prev">
                                <!-- Récupère l'URL de l'article précédent en utilisant son ID unique avec la fonction get_permalink() -->
                                <a href="<?php echo get_permalink($prev_post->ID); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/precedent.svg" alt="Précédent">
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($next_post)) : ?>
                            <div class="navigation-arrow-next">
                                <!-- Récupère l'URL de l'article Suivant en utilisant son ID unique avec la fonction get_permalink() -->
                                <a href="<?php echo get_permalink($next_post->ID); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/suivant.svg" alt="Suivant">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>



        <?php endwhile; ?>
    <?php endif; ?>





    <!--------------------------------------      les postes de la meme catégorie ------------------------------------------------------------------------------->


    <?php
    // Récupérez les termes de la catégorie pour le post actuel
    $terms = wp_get_post_terms(get_the_ID(), 'categorie'); // 'categorie' est l'identifiant de la taxonomie

    if (!empty($terms)) {
        $term_ids = array_map(function ($term) {
            return $term->term_id;
        }, $terms);

        $args = array(
            'post_type' => 'photo', // 'photo' est l'identifiant de  CPT
            'post_status' => 'publish',
            'posts_per_page' => 2, // Le nombre de photos à afficher
            // 'orderby' => 'rand', // Affichez les posts de manière aléatoire
            'post__not_in' => array(get_the_ID()), // Exclut le post actuel
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie', // Utilisez l'identifiant de votre taxonomie
                    // 'field'    => 'term_id',
                    'terms'    => $term_ids,
                ),
            ),
        );

        $related_posts = new WP_Query($args);
        if ($related_posts->have_posts()) {
            echo '<article>';
            echo ' <h2> VOUS AIMEREZ AUSSI </h2>';


            echo '<div class="container-photos-meme-categorie">';
            while ($related_posts->have_posts()) {
                $related_posts->the_post();

                get_template_part('template-parts/photo-block'); // Inclut le fichier de template 

            }
            echo '</div>';
            echo '</article>';
        }

        wp_reset_postdata(); // Réinitialiser les informations de la requête d'origine
    }






































    get_footer();
