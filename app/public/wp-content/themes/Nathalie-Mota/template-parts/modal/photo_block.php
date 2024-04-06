
<?php
// Récupérez les termes de la catégorie pour le post actuel
$terms = wp_get_post_terms(get_the_ID(), 'category'); // 'category' est l'identifiant de la taxonomie

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
                'taxonomy' => 'category', // Utilisez l'identifiant de votre taxonomie
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    );





    $related_posts = new WP_Query($args);
    if ($related_posts->have_posts()) {
        echo '<div class="related-posts-section">';
        while ($related_posts->have_posts()) {
            $related_posts->the_post();

            //get_template_part('template-parts/photo-content'); // Inclut le fichier de template partiel

            echo '<div class="related-photo-container">';
            the_post_thumbnail('medium'); // Assurez-vous d'avoir des tailles d'image appropriées définies
            echo '</div>';
            // the_title();
            //the_field('categorie');
        }
        echo '</div>';
    }

    wp_reset_postdata(); // Réinitialiser les informations de la requête d'origine
}
