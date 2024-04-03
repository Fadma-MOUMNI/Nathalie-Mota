


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


///////////////////////////////////////////////////////////////::///les postes au survol //slide de poste 

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


/////////////////////////////////////botton charger plus de poste 
var page = 1; // Suivre le nombre de pages chargées
document.getElementById('load-more').addEventListener('click', function () {
    page++;
    fetch('/wp-json/wp/v2/photo?per_page=8&page=' + page)
        .then(response => response.json())
        .then(photos => {
            photos.forEach(photo => {
                // Créez une nouvelle div pour chaque photo
                var photoDiv = document.createElement('div');
                photoDiv.className = 'photo';

                // Créez et ajoutez l'image
                var img = document.createElement('img');
                img.src = photo.media_details.sizes.full.source_url; // Utilisez l'URL de l'image
                photoDiv.appendChild(img);

                // Ajoutez d'autres détails si nécessaire, par exemple le titre de la photo
                var title = document.createElement('h2');
                title.textContent = photo.title.rendered;
                photoDiv.appendChild(title);

                // Ajoutez la nouvelle div au conteneur de photos existant
                document.querySelector('.catalogue-photos').appendChild(photoDiv);
            });
        });
});
////////////////////////////////////////////////////////////////////////////////////les filtres 
document.getElementById('filter-form').addEventListener('submit', function (e) {
    e.preventDefault();

    var category = document.getElementById('category-filter').value;
    var format = document.getElementById('format-filter').value;
    var dateOrder = document.getElementById('date-filter').value;

    fetch(`/wp-json/wp/v2/photo?categories=${category}&formats=${format}&order=${dateOrder}`)
        .then(response => response.json())
        .then(photos => {
            var container = document.getElementById('photos-container');
            container.innerHTML = ''; // Vide le conteneur avant d'ajouter de nouvelles photos
            photos.forEach(photo => {
                var photoDiv = document.createElement('div');
                photoDiv.className = 'photo';
                var img = document.createElement('img');
                img.src = photo.media_details.sizes.full.source_url; // Mettez à jour selon la structure de votre réponse
                photoDiv.appendChild(img);
                container.appendChild(photoDiv);
            });
        });
});
