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
                            $terms = get_the_terms(get_the_ID(), 'category');
                            if ($terms && !is_wp_error($terms)) {
                                $categories = array();
                                foreach ($terms as $term) {
                                    $categories[] = $term->name;
                                }
                                echo implode(', ', $categories); // Affiche les noms des catégories séparés par une virgule
                            }
                            ?>
                        </li>



                        <!-- -----------------Bloc pour afficher les formats en taxonomy --------------------------------------->
                        <li>FORMAT :
                            <?php
                            $formats = get_the_terms(get_the_ID(), 'format'); // 'format' est le nom réel de ta taxonomie pour le format
                            if ($formats && !is_wp_error($formats)) {
                                $format_names = array();
                                foreach ($formats as $format) {
                                    $format_names[] = $format->name;
                                }
                                echo implode(', ', $format_names); // Affiche les noms des formats séparés par une virgule
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


                <!--the_content()
                <div class="post-content">
                    <?php //the_content(); 
                    ?>
                </div>-->


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









    <article class="contenair-posts">

        <h2>VOUS AIMEREZ AUSSI</h2>
        <div>


            <?php get_template_part('template-parts/modal/photo_block'); ?>
        </div>
    </article>
</div>

</div>
















</div>















<?php get_footer(); ?>