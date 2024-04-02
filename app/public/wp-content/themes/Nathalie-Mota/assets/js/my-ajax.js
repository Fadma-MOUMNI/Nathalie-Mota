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
