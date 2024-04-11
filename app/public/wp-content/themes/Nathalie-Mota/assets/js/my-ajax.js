// S'assurer que le code ne s'exécute qu'après que le DOM de la page soit entièrement chargé
jQuery(document).ready(function ($) {
    // Sélectionner le bouton avec la classe 'lien-contact-photo' et attacher un écouteur d'événements de clic
    $('.lien-contact-photo').on('click', function () {
        // Récupérer la valeur de l'attribut de données 'photo-ref' qui contient la référence de la photo
        var refPhoto = $(this).data('photo-ref');
        // Sélectionner le champ du formulaire de contact qui a l'attribut 'name' égal à 'reference'
        var refPhotoField = $('input[name="reference"]');
        // Vérifier si le champ de formulaire existe
        if (refPhotoField.length) {
            // Définir la valeur du champ du formulaire avec la référence de la photo
            refPhotoField.val(refPhoto);
        }
        // Trouver le conteneur de la popup et changer sa propriété de visibilité pour l'afficher
        $('.popup_cover').css('visibility', 'visible');
    });
});

////////////////////////////////////////////////////////:le filtre du catalogue 
jQuery(document).ready(function ($) {
    $('#category-filter, #format-filter, #order-filter').change(function () {
        // Récupérez les valeurs des filtres ici.
        var category = $('#category-filter').val();
        var format = $('#format-filter').val();
        var order = $('#order-filter').val(); // Collecter la valeur de tri

        $.ajax({
            url: my_ajax_object.ajax_url, // L'URL pour la requête AJAX, définie via wp_localize_script
            method: 'POST',
            data: {
                action: 'filter_photos', // L'action que WordPress utilisera pour le hook dans fonction.php
                category: category, // La catégorie sélectionnée
                format: format, // Le format sélectionné
                order: order, // Ordre de tri (ASC ou DESC)
                nonce: my_ajax_object.nonce // Le nonce pour la vérification de sécurité
            },
            success: function (response) {
                // Si la requête réussit, mettez à jour le contenu de votre galerie de photos
                $('.catalogue-photos').html(response); // la classe correspond au conteneur de photos
            },
            error: function (errorThrown) {
                // les erreurs ici
                console.error('Erreur AJAX : ' + errorThrown);
                console.log(my_ajax_object)
            }
        });
    });
});





///////////////////////////////////////////charger plus de postes 
jQuery(document).ready(function ($) {
    var ajaxurl = my_ajax_object.ajax_url; // Assurez-vous que cette variable est correctement localisée dans votre fichier PHP.
    var page = 1; // La page initiale est la page 1.

    $('#load-more').click(function (e) {
        e.preventDefault();
        page++; // Incrémentez le numéro de la page à charger.

        var data = {
            'action': 'filter_photos', // L'action doit correspondre à celle que vous avez enregistrée dans WP AJAX hooks.
            'nonce': my_ajax_object.nonce, // Le nonce pour la sécurité.
            'page': page, // Transmettez le numéro de la page que vous chargez.

        };

        // Effectuez la requête AJAX.
        $.ajax({
            url: ajaxurl,
            data: data,
            type: 'POST',
            beforeSend: function (xhr) {
                // Vous pouvez ajouter une animation de chargement ici.
                $('#load-more').text('Chargement...');
            },
            success: function (response) {
                if (response.trim() === 'Aucune photo trouvée.') {
                    $('#load-more').hide(); // Cachez le bouton si la réponse est 'Aucune photo trouvée.'
                } else {
                    $('.container-catalogue .catalogue-photos').append(response);

                    $('#load-more').text('Charger plus'); // Réinitialiser le texte du bouton
                }
            }
        });
    });
});





