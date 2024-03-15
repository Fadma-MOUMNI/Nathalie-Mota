<?php
function nathalie_mota_css()
{
    // Ajouter le CSS en utilisant wp_enqueue_style
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'nathalie_mota_css');



function nathaliemota_enqueue_scripts()
{
    // Chargement des script JS
    wp_enqueue_script('nathalie-mota-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_scripts');










//// Enregistre les emplacements des menus pour permettre leur gestion dans le thème.
function register_my_menu()
{
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');








// *********************************************************$ajout un boton contact au menu 
/*function contact_btn($string)
{

    /** Code du bouton */
//// $string .= '<a href="#" id="contact_btn" class="contact">Contact</a>';

/** On retourne le code  */
//return $string;
//}

/** On publie le shortcode  */
//add_shortcode('contact', 'contact_btn');
//**********************************************************************************************/