


var contactButton = document.getElementById('lien-contact');
var popupCover = document.querySelector('.popup_cover');

//*********************Ouvrir la popup lorsque le bouton de contact est cliqué
contactButton.addEventListener('click', function () {
    // // Afficher la popup en modifiant la propriété de visibilité pour la rendre visible
    popupCover.style.visibility = 'visible';
});

//***********Fermer la popup en cliquant sur la zone de la grande div popup_cover
popupCover.addEventListener('click', function (e) {
    // Vérifier si l'élément cliqué est la grande div elle-même (avec la classe popup_cover)
    if (e.target === popupCover) {
        // Cacher la popup en modifiant la propriété visibility
        popupCover.style.visibility = 'hidden';
    }
});


