<!--Ce fichier est utilisé pour afficher le contenu des pages statiques d'un site.-->
<?php
// Boucle WordPress pour récupérer les pages
if (have_posts()) :
    while (have_posts()) :
        the_post();
?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- .entry-content -->

            <footer class="entry-footer">
                <?php
                // Si les commentaires sont autorisés sur cette page et qu'il y a au moins un commentaire, afficher le lien vers les commentaires
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </footer><!-- .entry-footer -->
        </article><!-- #post-<?php the_ID(); ?> -->
<?php
    endwhile;
else :
    // Si aucune page trouvée
    echo __('Désolé, aucune page trouvée.', 'votretheme');
endif;
?>