import { Modal } from "./modal.js";

function modalService(nomServicePlaceholder, dateOuverturePlaceholder, dateFermeturePlaceholder, checkboxPlaceholder, callback) {
    const modal = new Modal("Nouveau service");
    modal.creerTextField("Nom du service", "text", nomServicePlaceholder, "NomService");
    modal.creerTextField("Horaire d'ouverture", "time", dateOuverturePlaceholder, "TimeOuverture");
    modal.creerTextField("Horaire de fermeture", "time", dateFermeturePlaceholder, "TimeFermeture");
    modal.creerInputCheckbox("Service actif", checkboxPlaceholder, "Service");
    modal.creerButtons(callback);
    modal.afficher();

}

async function recupererServices() {
    const response = await fetch("/fileAttente/web/controleurFrontal.php?action=recupererServicesTableau&controleur=service", {
        method: "GET"
    })
    return await response.json();
}

function creerContenuService(service) {
    return `
        <div class="divNomServiceHoraireStatut">
            <div class="divNomServiceHoraire">
                <p class='titreServiceAdmin'>${service.nomService}</p>
                <p class='nbPersonneAttenteAdmin'>Horaires : ${service.horaireDebut} - ${service.horaireFin}</p>
            </div>
            <div class='${service.statutService ? "statutTermine" : "statutInactifAdmin"}'>
                ${service.statutService ? "Actif" : "Inactif"}
            </div>
        </div>
        <div class="actionsServices">
            <button id="btnModifierService"
                    onclick="modalService(
                            '${service.nomService.replace(/'/g, "\\'")}',
                            '${service.horaireDebut}',
                            '${service.horaireFin}',
                            '${service.statutService ? 1 : 0}',
                            () => mettreAJourService('${service.idService}'))">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen w-4 h-4"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>
            </button>
            <button id="btnSupprimerService" onclick="supprimerService('${service.idService}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 w-4 h-4"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
            </button>
        </div>
    `;
}

function ajouterServiceAuDOM(service) {
    const sectionServices = document.querySelector(".sectionServiceAdministration");
    const divService = document.createElement('div');
    divService.className = 'divService';
    divService.dataset.idService =service.idService;
    divService.innerHTML=creerContenuService(service);
    sectionServices.appendChild(divService);
}

function supprimerServiceDuDOM(service){
    const divService = document.querySelector(`[data-id-service='${service.idService}']`);
    if (divService) {
        divService.remove();
    }
}

function mettreAJourServiceDansDOM(service) {
    const ligneService = document.querySelector(`[data-id-service='${service.idService}']`);
    if (ligneService) {
        ligneService.innerHTML = '';
        ligneService.innerHTML = creerContenuService(service);
    }
}



async function mettreAJourService(idService) {
    const formData = new FormData();
    const inputNomService = document.getElementById("inputNomService");
    const inputTimeOuverture = document.getElementById("inputTimeOuverture");
    const inputTimeFermeture = document.getElementById("inputTimeFermeture");
    const checkboxService = document.getElementById("checkboxService");

    formData.append("idService", idService);
    formData.append("nomService", inputNomService.value);
    formData.append("horaireDebut", inputTimeOuverture.value);
    formData.append("horaireFin", inputTimeFermeture.value);
    formData.append("statutService", checkboxService.checked ? "1" : "0");

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourServiceAdministration&controleur=service", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de l'ajout du service");
    }
}

async function ajouterService() {
    const formData = new FormData();
    const inputNomService = document.getElementById("inputNomService");
    const inputTimeOuverture = document.getElementById("inputTimeOuverture");
    const inputTimeFermeture = document.getElementById("inputTimeFermeture");
    const checkboxService = document.getElementById("checkboxService");

    formData.append("nomService", inputNomService.value);
    formData.append("horaireDebut", inputTimeOuverture.value);
    formData.append("horaireFin", inputTimeFermeture.value);
    formData.append("statutService", checkboxService.checked ? "1" : "0");

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=creerServiceAdministration&controleur=service", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour du service");
    }
}

async function supprimerService(idService) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce service ?")) {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=supprimerServiceAdministration&controleur=service&idService=${idService}`, {
            method: "GET"
        });
     }
}

export {
    modalService,
    ajouterService,
    mettreAJourService,
    supprimerService,
    recupererServices,
    ajouterServiceAuDOM,
    mettreAJourServiceDansDOM,
    supprimerServiceDuDOM
}