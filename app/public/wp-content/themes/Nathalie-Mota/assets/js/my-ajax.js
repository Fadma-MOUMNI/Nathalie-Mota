
//////////////////////////////////////////////////////////le filtre du catalogue ////////////////////////////////////////////////////
jQuery(document).ready(function ($) {
    // Cette ligne assure que le code à l'intérieur ne s'exécute que lorsque le DOM est complètement chargé et que jQuery est prêt à être utilisé. Le '$' est passé comme argument pour pouvoir utiliser '$' au lieu de 'jQuery' dans le bloc de code, évitant les conflits avec d'autres bibliothèques.

    let page = 1; // Déclare une variable 'page' et initialise à 1. Cette variable garde la trace de la page courante pour la pagination.

    function loadPhotos(category, format, order, nextPage) {
        // Définition de la fonction 'loadPhotos' qui prend quatre paramètres pour charger les photos en fonction des filtres et de la page spécifiée.

        $.ajax({
            // Démarre une requête AJAX en utilisant jQuery. AJAX est utilisé pour interagir avec le serveur sans recharger la page.
            url: my_ajax_object.ajax_url,
            // 'url' est l'URL vers laquelle la requête est envoyée. Ici, elle utilise une variable définie dans le fichier PHP pour obtenir l'URL d'administration AJAX de WordPress.
            method: 'POST',
            // 'method' spécifie la méthode HTTP utilisée pour la requête, ici 'POST'.
            dataType: 'json', // Attendez une réponse en format JSON.
            data: {
                // 'data' contient les données envoyées au serveur.
                action: 'filter_photos', // Action WordPress pour laquelle AJAX doit répondre.(que j'ai creer dans le fichier function.php)
                categorie: category, // Catégorie de filtrage envoyée au serveur.
                format: format, // Format de filtrage envoyé au serveur.
                order: order, // Ordre de tri envoyé au serveur.
                page: nextPage, // Numéro de page envoyé pour la pagination.
                nonce: my_ajax_object.nonce // Un nonce pour sécuriser la requête.
            },
            // beforeSend: function () {
            // Fonction exécutée avant que la requête ne soit envoyée, utilisée ici pour modifier le texte du bouton et le désactiver.
            // $('#load-more').text('Chargement...').prop('disabled', true);
            //},
            success: function (response) {
                if (response.success) {
                    if (nextPage === 1) {
                        $('.catalogue-photos').html(response.data.html);
                    } else {
                        $('.catalogue-photos').append(response.data.html);
                    }
                    if (response.data.more_photos) {
                        $('#load-more').show().text('Charger plus').prop('disabled', false);
                    } else {
                        $('#load-more').hide();  // Cache le bouton s'il n'y a plus de photos à charger
                    }
                } else {
                    alert('Erreur: ' + response.data.message);
                    $('#load-more').text('Charger plus').prop('disabled', false);
                }
            },

        });

    }

    // Événements pour les changements de filtre
    $('#category-filter, #format-filter, #order-filter').change(function () {
        // Attache un gestionnaire d'événements aux éléments de filtrage pour détecter quand ils changent.
        page = 1; // Réinitialise la variable 'page' à 1 chaque fois que les filtres changent.

        loadPhotos(
            $('#category-filter').val(),
            $('#format-filter').val(),
            $('#order-filter').val(),
            page
        ); // Appelle 'loadPhotos' avec les nouveaux paramètres de filtrage.
    });

    $('#load-more').click(function () {
        // Attache un gestionnaire d'événements au bouton "Charger plus" pour gérer les clics.
        loadPhotos(
            $('#category-filter').val(),
            $('#format-filter').val(),
            $('#order-filter').val(),
            ++page
        ); // Incrémente la variable 'page' et appelle 'loadPhotos' pour charger la page suivante.
    });
});
