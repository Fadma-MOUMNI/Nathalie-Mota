<!--Ce fichier est utilisé pour afficher le contenu d'un article individuel d'un blog.-->

<<?php
    // Boucle WordPress pour récupérer les articles de blog
    if (have_posts()) :
        while (have_posts()) :
            the_post();
    ?> <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-meta">
            <?php
            printf(
                __('Publié le %s par %s', 'votretheme'),
                get_the_date(),
                get_the_author()
            );
            ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
            // Si le thème supporte les commentaires, afficher le lien vers les commentaires
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        ?>
    </footer><!-- .entry-footer -->
    </article><!-- #post-<?php the_ID(); ?> -->
<?php
        endwhile;
    else :
        // Si aucun article trouvé
        echo __('Désolé, aucun article trouvé.', 'votretheme');
    endif;
?>