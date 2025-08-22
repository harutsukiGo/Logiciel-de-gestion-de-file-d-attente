import { Modal } from "./modal.js";
import { recupererServices } from "./service.js";

async function recupererGuichets() {
    const response = await fetch("/fileAttente/web/controleurFrontal.php?action=recupererListeGuichet&controleur=guichet", {
        method: "GET"
    })
    return await response.json();
}

async function modalGuichet(nomGuichetPlaceholder, statutGuichetPlaceholder, idServicePlaceholder, callback) {
    const modal = new Modal("Nouveau guichet");
    modal.creerTextField("Nom du guichet", "text", nomGuichetPlaceholder, "NomGuichet");
    modal.creerInputCheckbox("Guichet actif", statutGuichetPlaceholder, "Guichet");
    await modal.creerInputSelect("Service lié", "inputGuichetService", idServicePlaceholder, recupererServices);
    modal.creerButtons(callback);
    modal.afficher();
}

async function ajouterGuichet() {
    const formData = new FormData();
    const nomGuichet = document.getElementById("inputNomGuichet");
    const statutGuichet = document.getElementById("checkboxGuichet");
    const idService = document.getElementById("inputGuichetService");

    formData.append("nom_guichet", nomGuichet.value);
    formData.append("statutGuichet", statutGuichet.checked ? "1" : "0");
    formData.append("idService", idService.value);

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=creerGuichetAdministration&controleur=guichet", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de l'ajout du guichet");
    }

}

async function mettreAJourGuichet(idGuichet) {
    const formData = new FormData();
    const nomGuichet = document.getElementById("inputNomGuichet");
    const statutGuichet = document.getElementById("checkboxGuichet");
    const idService = document.getElementById("inputGuichetService");

    formData.append("idGuichet", idGuichet)
    formData.append("nom_guichet", nomGuichet.value);
    formData.append("statutGuichet", statutGuichet.checked ? "1" : "0");
    formData.append("idService", idService.value);

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourGuichetAdministration&controleur=guichet", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour du guichet");
    }
}

async function supprimerGuichet(idGuichet) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce guichet ?")) {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=supprimerGuichetAdministration&controleur=guichet&idGuichet=${idGuichet}`, {
            method: "GET"
        })
    }
}

function creerConteneurGuichet(guichet) {
    return`
               <div class="divParentStatistiqueStatut">
                <div class="divParametresGuichet">
                    <p class='titreServiceAdmin'>${guichet.nomGuichet}</p>
                    ${guichet.listeAgent && guichet.listeAgent.length > 0
                         ? guichet.listeAgent.map(nomAgent => `<p class='nbPersonneAttenteAdmin'>Agent : ${nomAgent}</p>`).join("")
                         : `<p class='nbPersonneAttenteAdmin'>Aucun agent n'est attribué</p>`
                     }                     
                    <p class='nbPersonneAttenteAdmin'>${guichet.nomService ? "Service : " + guichet.nomService : "Aucun service n'est attribué"}</p>
                </div>
            <div class='${guichet.statutGuichet ? "statutTermine" :"statutInactifAdmin" }'>${guichet.statutGuichet ? "Actif" : "Inactif"} </div>
                </div>
                <div class="actionsServices">
                    <button id="btnModifierService" onclick="modalGuichet(
                            '${guichet.nomGuichet}',
                            '${guichet.statutGuichet ? 1 : 0}',
                            '${guichet.idServiceGuichet}',
                            () => mettreAJourGuichet('${guichet.idGuichet}'))">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16"' height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen w-4 h-4"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
                    </button>
                     <button id="btnSupprimerService" onclick="supprimerGuichet('${guichet.idGuichet}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                    </button>
                </div>
    `;
}

function ajouterGuichetAuDOM(guichet) {
    const divGuichet=document.createElement("div");
    divGuichet.className= "divGuichet";
    divGuichet.dataset.idGuichet = guichet.idGuichet;
    divGuichet.innerHTML=creerConteneurGuichet(guichet);
    document.querySelector(".sectionGuichetsAdministration").appendChild(divGuichet);
}

function mettreAJourGuichetAuDOM(guichet) {
    const divGuichet = document.querySelector(`[data-id-guichet='${guichet.idGuichet}']`);
    if (divGuichet){
        divGuichet.innerHTML='';
        divGuichet.innerHTML=creerConteneurGuichet(guichet);
    }
}

function supprimerGuichetDuDOM(guichet) {
    const divGuichet = document.querySelector(`[data-id-guichet='${guichet.idGuichet}']`);
    if (divGuichet){
        divGuichet.remove();
    }
}

export { modalGuichet, ajouterGuichet, mettreAJourGuichet, supprimerGuichet, recupererGuichets,ajouterGuichetAuDOM,mettreAJourGuichetAuDOM,supprimerGuichetDuDOM };