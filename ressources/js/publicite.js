import {Modal} from "./modal.js";


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

function creerContenuPublicite(publicite) {
    return `
        ${publicite.type === "vidéo"
        ? `<iframe class="imgPubliciteAdmin" src="https://www.youtube.com/embed/${publicite.nomFichier}" title="YouTube video player" allow="autoplay"></iframe>`
        : `<img class="imgPubliciteAdmin" src="${publicite.nomFichier}" alt="pub"/>`}
         <div class="bottomAction">

            <div class="divStatutOrdre">
             <div class='${publicite.actif ? "statutActifPub" : "statutInactifAdmin"}'>${publicite.actif ? "Actif" : "Inactif"}</div>
            <span class="ordre" id="ordrePub${publicite.idPublicite}"> Ordre : ${publicite.ordre}</span>
            </div>

            <div class="divParentsBtnFleche">

            <div class="divButtonFleche">
                <button id="btnHaut" onclick="augmenterOrdrePub(${publicite.idPublicite})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up w-4 h-4"><path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path></svg>
                </button>

                <button id="btnBas" onclick="diminuerOrdrePub(${publicite.idPublicite})">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down w-4 h-4"><path d="M12 5v14"></path><path d="m19 12-7 7-7-7"></path></svg>
                </button>
            </div>

            <div class="divButtonPublicite">
                 <button id="btnModifierService"
                        onclick="modalPublicite(
                                '${publicite.nomFichier}',
                                '${publicite.ordre}',
                                '${publicite.actif ? 1 : 0}',
                                '${publicite.type}',
                                () => mettreAJourPublicite('${publicite.idPublicite}'))">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-pen w-4 h-4">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                    </svg>
                </button>

                <button id="btnSupprimerService" onclick="supprimerPublicite('${publicite.idPublicite}'))">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-trash2 w-4 h-4">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </div>

            </div>

            </div>
      `;
}

function ajouterPubAuDOM(publicite) {
    const sectionPub = document.querySelector('.divPubliciteAdministration');
    const divPub = document.createElement('div');
    divPub.className = 'divPubliciteChild';
    divPub.dataset.idPublicite = publicite.idPublicite;
    divPub.innerHTML = creerContenuPublicite(publicite);
    sectionPub.appendChild(divPub);
}

function mettreAJourPubDOM(publicite) {
    const divPub = document.querySelector(`[data-id-publicite='${publicite.idPublicite}']`)
    if (divPub) {
        divPub.innerHTML = '';
        divPub.innerHTML = creerContenuPublicite(publicite);
    }
}

function supprimerPubDuDOM(publicite) {
    const divPub = document.querySelector(`[data-id-publicite='${publicite.idPublicite}']`)
    if (divPub) {
        divPub.remove();
    }
}

function changerOrdrePubDuDOM(publicite) {
    const divPub=document.getElementById(`ordrePub${publicite.idPublicite}`);
    if (divPub) {
        divPub.textContent=`Ordre : ${publicite.ordre}`;
    }
}

export {
    modalPublicite,
    ajouterPublicite,
    mettreAJourPublicite,
    supprimerPublicite,
    augmenterOrdrePub,
    diminuerOrdrePub,
    ajouterPubAuDOM,
    mettreAJourPubDOM,
    supprimerPubDuDOM,
    changerOrdrePubDuDOM
}