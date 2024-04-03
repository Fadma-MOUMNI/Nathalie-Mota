<?php
/////////////////////////////////////////////////////// Fonction pour ajouter le style CSS
function nathalie_mota_style()
{
    // Ajouter le CSS en utilisant wp_enqueue_style
    wp_enqueue_style('nathalie-mota-style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'nathalie_mota_style');

/////////////////////////////////////////////////////// Fonction pour charger les scripts JS
function nathalie_mota_enqueue_scripts()
{
    //ajax
    wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/assets/js/my-ajax.js', array('jquery'), null, true);
    wp_localize_script('my-ajax-script', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

    // Chargement des scripts JS
    wp_enqueue_script('nathalie-mota-script', get_template_directory_uri() . '/assets/js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_scripts');




////////////////////////////////// Enregistre les emplacements des menus pour permettre leur gestion dans le thème.
function register_my_menu()
{
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');








// ****************************************************************************ajout un boton contact au menu

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
////////////////////////////////////////////////////////////////////////////////botton de contact dans la page single.php
function load_contact_form()
{
    // Assurez-vous que le nonce est valide, ou utilisez check_ajax_referer si vous avez envoyé un nonce avec wp_localize_script
    $ref_photo = isset($_GET['ref_photo']) ? sanitize_text_field($_GET['ref_photo']) : '';
    echo do_shortcode('[contact-form-7 id="de70756" title="Contact form 1" your-object="' . $ref_photo . '"]');
    wp_die(); // Ceci est nécessaire pour terminer correctement la requête AJAX
}
add_action('wp_ajax_nopriv_load_contact_form', 'load_contact_form');
add_action('wp_ajax_load_contact_form', 'load_contact_form');




/////////////////////////////////////////////////////////////:////////Inclure FontAwesome à retirer !
function add_font_awesome()
{
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css');
}
add_action('wp_enqueue_scripts', 'add_font_awesome');
///////////////////////////////////////////////////////REPONDRE AU REQUETE AJAX 


// Cette fonction est appelée en réponse à votre requête AJAX
function filter_photos_callback()
{
    $category = $_POST['category'];
    $format = $_POST['format'];
    $date = $_POST['date'];

    // Préparez votre WP_Query avec les arguments de filtrage appropriés
    $args = array(
        // Vos arguments de requête ici
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {

        while ($query->have_posts()) {
            $query->the_post();
            // Ici, générez le HTML pour chaque photo comme vous le feriez dans votre template
            get_template_part('template-part-for-photo');
        }
    } else {
        echo 'Aucune photo trouvée pour les critères sélectionnés.';
    }

    wp_reset_postdata();






    wp_die(); // Cela est nécessaire pour terminer correctement la requête AJAX
}

// Ajoutez les actions WordPress pour le traitement AJAX
add_action('wp_ajax_filter_photos', 'filter_photos_callback'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos_callback'); // Pour les utilisateurs non connectés
