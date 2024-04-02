<!--la bannier-->

<?php
// Préparation de la requête pour obtenir un post aléatoire du type 'photo'
$args = array(
    'post_type' => 'photo', // Spécifie le type de post à récupérer
    'orderby'   => 'rand', // Trier les posts de manière aléatoire
    'posts_per_page' => 1, // Récupérer seulement un post
);
$random_post_query = new WP_Query($args); // Créer la requête WP_Query avec les arguments

// Vérifier si des posts sont disponibles
if ($random_post_query->have_posts()) {
    while ($random_post_query->have_posts()) {
        $random_post_query->the_post(); // Mettre en place le post pour les fonctions de template
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Récupérer l'URL de l'image à la une
    }
}
wp_reset_postdata(); // Réinitialiser les données de la requête
?>

<!-- Vérifier si l'URL de l'image a été récupérée et afficher l'image -->
<?php if (isset($image_url)) : ?>
    <div class="bannier">
        <img src="<?php echo esc_url($image_url); ?>" alt="Image aléatoire"> <!-- Afficher l'image -->
        <h1><?php bloginfo('description'); ?></h1>

    </div>
<?php endif; ?>
<!-- Fin de la bannière -->