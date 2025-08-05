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
    recupererServices
}