


var contactButton = document.getElementById('lien-contact');
var popupCover = document.querySelector('.popup_cover');

//*********************Ouvrir la popup lorsque le bouton de contact est cliqué
contactButton.addEventListener('click', function () {
    // // Afficher la popup en modifiant la propriété de visibilité pour la rendre visible
    popupCover.style.visibility = 'visible';
    /* Pré-remplissez le champ de référence
    var refPhoto = this.getAttribute('data-ref-photo');
    var refPhotoField = document.querySelector('input[name="ref-photo"]');
    if (refPhotoField) {
        refPhotoField.value = refPhoto;
    }*/
});

//***********Fermer la popup en cliquant sur la zone de la grande div popup_cover
popupCover.addEventListener('click', function (e) {
    // Vérifier si l'élément cliqué est la grande div elle-même (avec la classe popup_cover)
    if (e.target === popupCover) {
        // Cacher la popup en modifiant la propriété visibility
        popupCover.style.visibility = 'hidden';
    }
});


///////////////////////////////////////////////////////////////::///les postes au survol

document.querySelectorAll('.prev-photo, .next-photo').forEach(function (element) {
    element.addEventListener('mouseenter', function () {
        var thumbnail = this.getAttribute('data-thumbnail');
        var img = document.createElement('img');
        img.src = thumbnail;
        img.style.position = '';
        img.style.top = '100%'; // Positionnez l'image en dessous du lien
        img.className = 'photo-thumbnail'; // Ajoutez une classe pour un style CSS additionnel
        this.appendChild(img);
    });
    element.addEventListener('mouseleave', function () {
        var img = this.querySelector('.photo-thumbnail'); // Assurez-vous que le sélecteur est correct
        if (img) {
            this.removeChild(img);
        }
    });
});
