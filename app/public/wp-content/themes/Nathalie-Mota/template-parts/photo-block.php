<?php







// s'assurer que la variable globale $post est disponible
global $post;

// Obtenir le lien permanent du post
$post_link = get_permalink($post->ID);

echo '<div class="photo">';
// Ici, on ajoute un élément 'a' autour de la vignette pour créer un lien cliquable
//echo '<a href="' . esc_url($post_link) . '">';
the_post_thumbnail('medium'); // Affiche la vignette du post avec une taille 'medium'.
//echo '</a>'; // Fin du lien
//div au survol 
echo '<div class="overlay">'; //*****************************************/

//ici icon plain ecran 
echo '<div class="container-fullscreen-icon">';
echo '<img src="' . get_template_directory_uri() . '/assets/img/fullscreen.png" alt="icône fullscreen "/>';
echo '</div>';



//ici icon eye  
echo '<div class="container-eye-icon">';
echo '<a href="' . get_permalink() . '" class="eye-icon">';
echo '<img src="' . get_template_directory_uri() . '/assets/img/eye.png" alt="icône eye"/>';
echo '</a>';
echo '</div>';

//ici reference et categorie 
echo '<div class="container-catego-reference">'; //*********/

echo '<div>';
echo '<p>';
the_field('reference');
echo '</p>';
echo '</div>';

echo '<div>';
echo '<p>';
the_field('categorie');
echo '</p>';
echo '</div>';

echo '</div>'; //*******************************************/


echo '</div>'; //*****************************************************/fin div overlay



echo '</div>';//fin div photo










//echo '<div>';
// Ici, on peut ajouter d'autres informations sur le post, comme le titre, l'extrait, etc.
/*
echo '<div class="card-photo" >';
echo '<div>';
'<img src="<?php echo get_template_directory_uri(); ?>/assets/img/fullscreen.png" alt="icône-fullscreen">'; //lightbox
echo '</div>';
echo '<div class="container-eye-icon">';
echo '<a href="' . get_permalink() . '" class="eye-icon">';
echo '<img src="' . get_template_directory_uri() . '/assets/img/eye.png" alt="icône"/>';
echo '</a>';
echo '</div>';


echo '<div class="container-catego-reference">';
echo '<div>';
the_field('reference');
echo '</div>';

echo '<div>';
the_field('categorie');
echo '</div>';

echo '</div>';
echo '</div>';

echo '</div>';
echo '<div>';*/
