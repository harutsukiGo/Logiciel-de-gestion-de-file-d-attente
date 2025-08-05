import { Modal } from "./modal.js";


async function augmenterOrdrePub(idPub) {
    await fetch(`/fileAttente/web/controleurFrontal.php?action=augmenterOrdre&controleur=publicite&idPublicites=${idPub}`, {
        method: "GET"
    });
}

async function diminuerOrdrePub(idPub) {
    await fetch(`/fileAttente/web/controleurFrontal.php?action=diminuerOrdre&controleur=publicite&idPublicites=${idPub}`, {
        method: "GET"
    });
}

function modalPublicite(nomFichierPlaceholder, ordrePlaceholder, statutPlaceholder, typePlaceholder, callback) {
    const modal = new Modal("Nouvelle publicité");

    modal.creerTextField("URL du fichier", "text", nomFichierPlaceholder, "NomFichier");
    modal.creerTextField("Ordre", "number", ordrePlaceholder, "Ordre");
    modal.creerSelecteur("Type", "inputType", [
        {valeur: "image", texte: "image"},
        {valeur: "vidéo", texte: "vidéo"}
    ], typePlaceholder);
    modal.creerInputCheckbox("Publicité active ", statutPlaceholder, "Publicite");
    modal.creerButtons(callback);
    modal.afficher();
}

async function ajouterPublicite() {
    const formData = new FormData();
    const nomFichier = document.getElementById("inputNomFichier");
    const ordre = document.getElementById("inputOrdre");
    const statut = document.getElementById("checkboxPublicite");
    const type = document.getElementById("inputType");

    formData.append("fichier", nomFichier.value);
    formData.append("ordre", ordre.value);
    formData.append("actif", statut.checked ? "1" : "0");
    formData.append("type", type.value);

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=creerPubliciteAdministration&controleur=publicite", {
            method: "POST",
            body: formData,
        })
    } catch (e) {
        console.error("Erreur lors de l'ajout de la publicité");
    }
}

async function mettreAJourPublicite(idPub) {
    const formData = new FormData();
    const nomFichier = document.getElementById("inputNomFichier");
    const ordre = document.getElementById("inputOrdre");
    const statut = document.getElementById("checkboxPublicite");
    const type = document.getElementById("inputType");

    formData.append("idPublicites", idPub);
    formData.append("fichier", nomFichier.value);
    formData.append("ordre", ordre.value);
    formData.append("actif", statut.checked ? "1" : "0");
    formData.append("type", type.value);

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourPubliciteAdministration&controleur=publicite", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour de la publicité");
    }
}

async function supprimerPublicite(idPub) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette publicité ?")) {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=supprimerPubliciteAdministration&controleur=publicite&idPublicites=${idPub}`, {
            method: "GET"
        });
    }
}


export {
    modalPublicite,
    ajouterPublicite,
    mettreAJourPublicite,
    supprimerPublicite,
    augmenterOrdrePub,
    diminuerOrdrePub
}