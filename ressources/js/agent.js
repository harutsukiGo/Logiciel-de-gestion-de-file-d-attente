import { Modal } from "./modal.js";
import { recupererGuichets } from "./guichet.js";
import { recupererServices } from "./service.js";

async function modalAgent(nomAgent, mailAgent, statutAgent, loginAgent, motDePasseAgent, roleAgent, idGuichet, idService, callback) {
    const modal = new Modal("Nouvel agent");
    modal.creerTextField("Nom complet", "text", nomAgent, "NomAgent");
    modal.creerTextField("Email", "text", mailAgent, "MailAgent");
    modal.creerTextField("Login", "text", loginAgent, "LoginAgent");
    modal.creerTextField("Mot de passe", "password", motDePasseAgent, "MotDePasseAgent");
    modal.creerSelecteur("Rôle agent", "inputRoleAgent", [
        {valeur: "agent", texte: "agent"},
        {valeur: "administrateur", texte: "administrateur"}
    ], roleAgent);
    await modal.creerInputSelect("Guichet", "inputGuichetAgent", idGuichet, recupererGuichets);
    await modal.creerInputSelect("Services", "inputServiceAgent", idService, recupererServices);
    modal.creerInputCheckbox("Agent actif", statutAgent, "Agent");
    modal.creerButtons(callback);
    modal.afficher();
}

async function mettreAJourAgent(idAgent) {
    const formData = new FormData();
    const nomAgent = document.getElementById("inputNomAgent");
    const mailAgent = document.getElementById("inputMailAgent");
    const loginAgent = document.getElementById("inputLoginAgent");
    const motDePasseAgent = document.getElementById("inputMotDePasseAgent");
    const roleAgent = document.getElementById("inputRoleAgent");
    const guichetAgent = document.getElementById("inputGuichetAgent");
    const statutAgent = document.getElementById("checkboxAgent");
    const idServiceAgent = document.getElementById("inputServiceAgent");


    formData.append("idAgent", idAgent);
    formData.append("nomAgent", nomAgent.value);
    formData.append("idAgent", idAgent);
    formData.append("mailAgent", mailAgent.value);
    formData.append("statutAgent", statutAgent.checked ? "1" : "0");
    formData.append("loginAgent", loginAgent.value);
    formData.append("motDePasseAgent", motDePasseAgent.value);
    formData.append("roleAgent", roleAgent.value);
    formData.append("idGuichet", guichetAgent.value);
    formData.append("idService", idServiceAgent.value);

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourAgentAdministration&controleur=agent&", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de l'ajout de l'agent");
    }
}

async function ajouterAgent() {
    const formData = new FormData();
    const nomAgent = document.getElementById("inputNomAgent");
    const mailAgent = document.getElementById("inputMailAgent");
    const loginAgent = document.getElementById("inputLoginAgent");
    const motDePasseAgent = document.getElementById("inputMotDePasseAgent");
    const roleAgent = document.getElementById("inputRoleAgent");
    const guichetAgent = document.getElementById("inputGuichetAgent");
    const statutAgent = document.getElementById("checkboxAgent");
    const idServiceAgent = document.getElementById("inputServiceAgent");

    formData.append("nomAgent", nomAgent.value);
    formData.append("mailAgent", mailAgent.value);
    formData.append("statutAgent", statutAgent.checked ? "1" : "0");
    formData.append("loginAgent", loginAgent.value);
    formData.append("motDePasseAgent", motDePasseAgent.value);
    formData.append("roleAgent", roleAgent.value);
    formData.append("idGuichet", guichetAgent.value);
    formData.append("idService", idServiceAgent.value);

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=creerAgentAdministration&controleur=agent", {
            method: "POST",
            body: formData,
        });
    } catch (e) {
        console.error("Erreur lors de l'ajout de l'agent");
    }

}


async function supprimerAgent(idAgent) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet agent ?")) {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=supprimerAgentAdministration&controleur=agent&idAgent=${idAgent}`, {
            method: "GET"
        });
    }
}

async function mettreAJourStatutAgent(statut, texte, removeClass, addClass, btnId) {
    const btn = document.getElementById(btnId);
    const idAgent = document.getElementById("idAgent");
    if (!btn || !idAgent) return;
    try {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutAgent&controleur=agent&idAgent=${idAgent.value}&statut=${btn.dataset.statut}`, {
            method: "GET"
        });
        const divStatut = document.getElementById("divStatutAgent");
        if (divStatut) {
            divStatut.textContent = texte;
            divStatut.classList.remove(removeClass);
            divStatut.classList.add(addClass);
        }
    } catch (e) {
        console.error("Erreur lors de la mise à jour du statut de l'agent:", e);
    }
}

function mettreAJourStatutAgentFermer() {
    mettreAJourStatutAgent("ferme", "Fermé", "statutAgentOuvert", "statutAgentFerme", "btnFermer");
}

function mettreAJourStatutAgentOuvert() {
    mettreAJourStatutAgent("ouvert", "Ouvert", "statutAgentFerme", "statutAgentOuvert", "btnOuvrir");
}


export {
    modalAgent,
    mettreAJourAgent,
    ajouterAgent,
    supprimerAgent,
    mettreAJourStatutAgent,
    mettreAJourStatutAgentFermer,
    mettreAJourStatutAgentOuvert
};