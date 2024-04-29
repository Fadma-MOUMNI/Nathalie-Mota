
//////////////////////////////////////////////////////////////////////////////LA POPUP CONTACT////////////////////////////////////////////////////

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


//////////////////////////////////////////////////////////////// POPUP avec la reference //////////////////////////////////////////////////////

// S'assurer que le code ne s'exécute qu'après que le DOM de la page soit entièrement chargé
jQuery(document).ready(function ($) {
    // Sélectionner le bouton avec la classe 'lien-contact-photo' et attacher un écouteur d'événements de clic
    $('.lien-contact-photo').on('click', function () {
        // Récupérer la valeur de l'attribut data-photo-ref du boutton .
        const refPhoto = $(this).data('photo-ref');
        // ici on indique où insérer cette valeur dans le formulaire (trouve le champ qui a le nom "reference" dans Contact Form 7)
        const refPhotoField = $('input[name="reference"]');
        // Vérifier si le champ de formulaire existe
        if (refPhotoField.length) {
            // Si le champ existe, insérer la référence de la photo dans ce champ
            refPhotoField.val(refPhoto);
        }
        // Trouver le conteneur de la popup et changer sa propriété de visibilité pour l'afficher
        $('.popup_cover').css('visibility', 'visible');
    });
});



/////////////////////////////////////////////////////////La miniature des postes au survol ////////////////////////////////////////////////////

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

/////////////////////////////////////////////////////////LE MENU MOBIL//////////////////////////////////////////////////////////////////

// Sélectionnez le bouton hamburger en utilisant sa classe.
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const logoContainer = document.querySelector('.container_logo_menu_hamburger'); // Sélection du conteneur

// Ajoutez un écouteur d'événement pour écouter le clic sur le bouton.
hamburger.addEventListener('click', function () {

    // Ajoutez ou retirez la classe 'open' à chaque clic.
    this.classList.toggle('open');

    // Ajoutez ou retirez la classe 'open' du menu à chaque clic.
    navMenu.classList.toggle('open');
    // navMenu.classList.toggle('close');

    // logoContainer.classList.toggle('open'); // Appliquer la classe 'open' au conteneur également



    /*fermer la nav
    if (!navMenu.classList.contains('open')) {
        // Si la classe 'open' a été retirée, masquez le menu de navigation
        navMenu.style.display = 'none';
    }*/


    /*
        // Vérifiez si la classe 'open' a été ajoutée
        if (navMenu.classList.contains('open')) {
            // Si la classe 'open' a été ajoutée, affichez le menu de navigation
            navMenu.style.display = 'block';
        } else {
            // Si la classe 'open' a été retirée, masquez le menu de navigation
            navMenu.style.display = 'none';
        }*/



});




// Ajoutez un écouteur d'événements pour détecter la fin de l'animation
navMenu.addEventListener('animationend', function (event) {
    if (event.animationName === 'slideOut') {
        // Si c'est le cas, masquez l'élément en le mettant en display none
        navMenu.style.display = 'none';
    }
});


/////////////////////////////////////////////////////les champs des filtres avec select2//////////////////////////////////////////////

jQuery(document).ready(function ($) {
    // Initialise Select2 sur les éléments de sélection
    $('.option-filter').select2();


});


///////////////////////////////////////////////////////////////////Lightbox///////////////////////////////////////////////////////////

//////////////////////////////////////////:/Fonction pour ouvrir la lightbox avec des données de l'image

function openLightbox(imageUrl, reference, categoryName, element) {
    const lightbox = document.getElementById('lightboxModal');
    document.getElementById('lightbox-img').src = imageUrl;
    document.getElementById('lightbox-reference').textContent = reference;
    document.getElementById('lightbox-category').textContent = categoryName;
    lightbox.style.display = 'block';
    const photoElement = element.closest('.photo');
    document.getElementById('lightboxModal').currentElement = photoElement;

}

/////////////////////////////////////////////////////////////// Fonction pour fermer la lightbox
function closeLightbox() {
    document.getElementById('lightboxModal').style.display = 'none';
}
//////// Écouteur d'événement pour le bouton de fermeture
const closeButton = document.getElementById('lightbox-close');
closeButton.addEventListener('click', closeLightbox);
closeButton.addEventListener('click', function () {
    closeButton.classList.add("animation-cosLightbox");
});


/////////////////////////////////////////////////////////// Fonction pour aller à l'image suivante
function nextlightbox() {
    let currentPhoto = document.getElementById('lightboxModal').currentElement;
    let nextPhoto = currentPhoto.nextElementSibling;

    // Si nextPhoto est null, cela signifie que nous sommes sur le dernier élément.
    // Nous devons alors boucler en retournant au premier élément .photo.
    if (!nextPhoto) {
        nextPhoto = document.querySelector('.photo'); // Sélectionnez le premier .photo dans le document.
    }

    // Maintenant que nous avons un nextPhoto (soit le suivant, soit le premier),
    // nous pouvons simuler un clic sur le .container-fullscreen-icon à l'intérieur.
    const fullscreenIcon = nextPhoto.querySelector('.container-fullscreen-icon');
    if (fullscreenIcon) {
        fullscreenIcon.click();
    }
}
/////////////////////////////////////////////////////////// Fonction pour aller à l'image précédente

function prevlightbox() {
    let currentPhoto = document.getElementById('lightboxModal').currentElement;
    let prevPhoto = currentPhoto.previousElementSibling;

    // Si prevPhoto est null, cela signifie que nous sommes sur le premier élément.
    // Nous devons alors boucler en allant au dernier élément .photo.
    if (!prevPhoto) {
        prevPhoto = document.querySelector('.photo:last-child'); // Sélectionnez le dernier .photo dans le document.
    }

    // Maintenant que nous avons un prevPhoto (soit le précédent, soit le dernier),
    // nous pouvons simuler un clic sur le .container-fullscreen-icon à l'intérieur.
    const fullscreenIcon = prevPhoto.querySelector('.container-fullscreen-icon');
    if (fullscreenIcon) {
        fullscreenIcon.click();
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


