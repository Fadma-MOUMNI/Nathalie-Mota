<?php
/////////////////////////////////////////////////////// Fonction pour ajouter le style CSS
function nathalie_mota_style()
{
    // Ajouter le CSS en utilisant wp_enqueue_style
    wp_enqueue_style('nathalie-mota-style-css', get_template_directory_uri() . '/assets/scss/style.css', array(), '1.0', 'all');
    //wp_enqueue_style('nathalie-mota-style-css', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');

    // Ajouter le CSS de Select2
    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), null);
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

    // Ajouter le JS de Select2
    wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js', array('jquery'), '4.0.13', true);
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



/////////////////////////////////////////// Répond aux requêtes AJAX pour filtrer les photos selon différentes critères.

function filter_photos()
{
    // Vérification de la sécurité : Nonce envoyé par AJAX
    check_ajax_referer('my_ajax_nonce', 'nonce');

    // Récupérer et sécuriser les informations sur la catégorie choisie depuis le formulaire.
    $category = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'ASC'; // Définir une valeur par défaut pour l'ordre


    // Détermine le numéro de la page courante pour la pagination. Si aucun numéro n'est spécifié, 
    // commence à la première page (1). pour afficher un sous-ensemble de posts (photos)sur la page actuelle.
    $paged = isset($_POST['page']) ? absint($_POST['page']) : 1; // Utiliser absint pour garantir un entier positif






    // Préparation de la requête taxonomique basée sur les filtres reçus.
    $tax_query = array('relation' => 'AND'); // Définit comment les filtres doivent interagir entre eux.
    // 'relation' => 'AND' signifie que toutes les conditions de la taxonomie doivent être remplies pour qu'un post soit inclus.

    if (!empty($category)) { // Vérifie si une catégorie a été sélectionnée.
        $tax_query[] = array( // Ajoute un filtre de taxonomie pour la catégorie.
            'taxonomy' => 'categorie', // La taxonomie à filtrer, ici c'est 'categorie'.
            'field'    => 'slug', // Le champ de la taxonomie à vérifier, ici c'est le 'slug' 
            'terms'    => $category, // La valeur spécifique à rechercher dans cette taxonomie.
        );
    }
    if (!empty($format)) {
        $tax_query[] = array( // Ajoute un filtre de taxonomie pour le format.
            'taxonomy' => 'format', // La taxonomie à filtrer, ici c'est 'format'.
            'field'    => 'slug',
            'terms'    => $format,
        );
    }
    // Arguments pour la requête WP_Query.
    $args = array(
        'post_type' => 'photo', // Le type de post à rechercher, ici des photos.
        'tax_query' => $tax_query, // Les filtres de taxonomie à appliquer à la requête.
        'order' => $order, // L'ordre de tri des posts, ASC ou DESC.
        'posts_per_page' => 8, // Combien de posts à afficher par page.
        'paged' => $paged, // La page de résultats à afficher.
    );
    // Exécution de la requête
    $query = new WP_Query($args);

    // Initialise la variable qui va accumuler le code HTML généré pour les photos.
    $html = '';
    // Initialise un indicateur pour déterminer s'il y a plus de photos à charger après la page actuelle.
    $more_photos = false;

    // Vérifie si la requête WP_Query a trouvé des posts correspondant aux critères de filtrage.
    if ($query->have_posts()) {
        // Commence la capture du HTML généré par les templates.
        ob_start();
        // Boucle sur chaque post trouvé par la requête.
        while ($query->have_posts()) {
            $query->the_post();  // Prépare les données du post pour l'affichage.

            get_template_part('template-parts/photo-block');
        }
        // Termine la capture du HTML et le stocke dans la variable $html.
        $html = ob_get_clean();
        // Détermine s'il y a plus de pages de résultats à afficher.
        $more_photos = ($query->max_num_pages > $query->query_vars['paged']);

        // Envoie une réponse JSON avec le HTML des photos et un indicateur de la disponibilité d'autres photos.
        wp_send_json_success(array('html' => $html, 'more_photos' => $more_photos));
    } else {
        // Si aucune photo n'est trouvée, envoie un message d'erreur.
        wp_send_json_error(array('message' => 'Aucune photo trouvée.'));
    }
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
