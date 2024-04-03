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

////////////////////////////////////////////////////////:les filtres 
jQuery(document).ready(function ($) {
    // Quand les filtres changent, exécutez cette fonction
    $('#category-filter, #format-filter, #date-filter').change(function () {
        var category = $('#category-filter').val();
        var format = $('#format-filter').val();
        var date = $('#date-filter').val();

        $.ajax({
            method: 'POST',
            url: my_ajax_object.ajax_url,
            data: {
                'action': 'filter_photos', // L'action que WordPress utilisera pour le hook
                'category': category,
                'format': format,
                'date': date
            },
            success: function (response) {
                // Mettez à jour la zone d'affichage des photos avec les nouvelles photos
                $('.container-catalogue').html(response);
            },
            error: function (error) {
                // Vous pouvez gérer les erreurs ici
                console.log(error);
            }
        });
    });
});

