

//////////////////////////////////////////////////////////////////////////////////////LA POPUP


const contactButton = document.getElementById('lien-contact');
const popupCover = document.querySelector('.popup_cover');

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


/////////////////////////////////////////////////////////////////////////////////les postes au survol //slide de poste 

// Sélectionner les éléments pour la navigation et les photos de posts précédent et suivant
const navArrowNext = document.querySelector('.navigation-arrow-next');
const navArrowPrev = document.querySelector('.navigation-arrow-prev');
const nextPhoto = document.querySelector('.next-photo');
const prevPhoto = document.querySelector('.prev-photo');

// Si la flèche de navigation suivante et la photo du post suivant existent dans le DOM
if (navArrowNext && nextPhoto) {
    // Ajouter un gestionnaire d'événements pour le survol de la souris sur la flèche suivante
    navArrowNext.addEventListener('mouseover', () => {
        // Rendre visible la photo du post suivant
        nextPhoto.style.visibility = 'visible';
    });

    // Ajouter un gestionnaire pour l'événement 'mouseout'
    // pour cacher la photo du post suivant lorsque la souris quitte la flèche
    navArrowNext.addEventListener('mouseout', () => {
        nextPhoto.style.visibility = 'hidden';
    });
}

// Si la flèche de navigation précédente et la photo du post précédent existent dans le DOM
if (navArrowPrev && prevPhoto) {
    // Ajouter un gestionnaire d'événements pour le survol de la souris sur la flèche précédente
    navArrowPrev.addEventListener('mouseover', () => {
        // Rendre visible la photo du post précédent
        prevPhoto.style.visibility = 'visible';
    });

    // Ajouter un gestionnaire pour l'événement 'mouseout'
    // pour cacher la photo du post précédent lorsque la souris quitte la flèche
    navArrowPrev.addEventListener('mouseout', () => {
        prevPhoto.style.visibility = 'hidden';
    });
}







