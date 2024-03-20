<?php
// Fonction pour ajouter le style CSS
function nathalie_mota_style()
{
    // Ajouter le CSS en utilisant wp_enqueue_style
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'nathalie_mota_style');

// Fonction pour charger les scripts JS
function nathalie_mota_enqueue_scripts()
{
    // Chargement des scripts JS
    wp_enqueue_script('nathalie-mota-script', get_template_directory_uri() . '/assets/js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_scripts');









//// Enregistre les emplacements des menus pour permettre leur gestion dans le thème.
function register_my_menu()
{
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');








// *********************************************************$ajout un boton contact au menu

// Fonction pour ajouter un lien "Contact" au menu de navigation
function ajouter_lien_contact_menu($items, $args)
{
    // Vérifiez si c'est le menu principal
    if ($args->theme_location == 'main') {
        // Ajoutez le lien "Contact" à la fin du menu
        $items .= '<li><a href="#" id="lien-contact">CONTACT</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'ajouter_lien_contact_menu', 10, 2);
/////////////////////////////////////////////////////////////////////////////////////////
