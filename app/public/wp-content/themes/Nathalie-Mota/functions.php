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
    // Enregistrer le script AJAX
    wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/assets/js/my-ajax.js', array('jquery'), null, true);
    // Localiser le script avec des données supplémentaires
    wp_localize_script('my-ajax-script', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL pour les requêtes AJAX
        'nonce' => wp_create_nonce('my_ajax_nonce') // Créer un nonce pour sécuriser la requête
    ));
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

function filter_photos()
{
    // Vérifier le nonce envoyé par AJAX
    check_ajax_referer('my_ajax_nonce', 'nonce');

    // Récupérer les données envoyées par AJAX
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $order = isset($_POST['order']) ? $_POST['order'] : ''; // Récupérer l'ordre de tri
    // Ajouter une récupération pour 'page'
    $paged = isset($_POST['page']) ? $_POST['page'] : 1;



    // Créer une tax_query basée sur les filtres reçus
    $tax_query = array('relation' => 'AND');
    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }
    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }


    // Construire la WP_Query
    $args = array(
        'post_type' => 'photo',
        'tax_query' => $tax_query,
        'order' => $order, // Ordre de tri (ASC ou DESC)
        'posts_per_page' => 8,
        'paged' => $paged,


    );
    $query = new WP_Query($args);

    // Générer le HTML pour la réponse
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/photo-block'); // Le template de photo

        }
    } else {
        echo 'Aucune photo trouvée.';
    }

    wp_reset_postdata();
    wp_die(); // Termine correctement la requête AJAX
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
