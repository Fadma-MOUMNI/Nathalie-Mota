<?php

// s'assurer que la variable globale $post est disponible
global $post;

echo '<div class=" photo">';
the_post_thumbnail('medium'); // Affiche la vignette du post avec une taille 'medium'.

// Ici, on peut ajouter d'autres informations sur le post, comme le titre, l'extrait, etc.
//the_title();
//the_field('categorie');

echo '</div>';
