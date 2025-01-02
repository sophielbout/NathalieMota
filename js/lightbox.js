document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("lightboxModal");
    const modalPhoto = modal.querySelector(".lightbox-photo");
    const prevButton = modal.querySelector(".prev");
    const nextButton = modal.querySelector(".next");
    const closeButton = modal.querySelector(".close");

    let currentIndex = 0; // Index de la photo actuelle
    let photos = []; // Liste des photos de la galerie

    // Récupérer toutes les photos au chargement
    document.querySelectorAll('.card-photo .icon-fullscreen').forEach((icon, index) => {
        photos.push({
            src: icon.dataset.src,
            ref: icon.dataset.ref,
            cat: icon.dataset.cat,
            title: icon.dataset.title || "Titre non disponible",
        });

        // Associer l'événement de clic pour ouvrir la lightbox
        icon.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            currentIndex = index; // Mettre à jour l'index courant
            openLightbox(currentIndex);
        });
    });

    function openLightbox(index) {
        const photo = photos[index];

        if (!photo.src || !photo.src.startsWith("http")) {
            console.error("URL invalide pour la photo :", photo.src);
            return;
        }

        const content = `
        <img src="${photo.src}" alt="Photo en grand" class="lightbox-hero" />
        <div class="lightbox-info">
            <h2 class="lightbox-photo-title">${photo.title || 'Titre non disponible'}</h2>
            <div id="lightbox-ref-cat">
                <p class="reference">${photo.ref}</p>
                <p class="category">${photo.cat}</p>
            </div>
        </div>
    `;

        // Injecter et loguer le contenu
        console.log("Contenu injecté :", content);
        modalPhoto.innerHTML = content;

        modal.style.display = "flex";
        modal.classList.add("show");
    }

    // Fonction pour naviguer vers la photo précédente
    function showPrevious() {
        currentIndex = (currentIndex - 1 + photos.length) % photos.length; // Navigation infinie
        openLightbox(currentIndex);
    }

    // Fonction pour naviguer vers la photo suivante
    function showNext() {
        currentIndex = (currentIndex + 1) % photos.length; // Navigation infinie
        openLightbox(currentIndex);
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        modal.classList.remove("show");
        modal.style.display = "none";
    }

    // Assurez-vous que la lightbox est masquée au chargement
    modal.classList.remove("show");
    modal.style.display = "none";

    // Associer les événements des boutons
    prevButton.addEventListener("click", (e) => {
        e.stopPropagation();
        showPrevious();
    });

    nextButton.addEventListener("click", (e) => {
        e.stopPropagation();
        showNext();
    });

    closeButton.addEventListener("click", (e) => {
        e.stopPropagation();
        closeLightbox();
    });

    // Fermer la lightbox si on clique en dehors du contenu
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeLightbox();
        }
    });
});
