import {Modal} from "./modal.js";
import {recupererGuichets} from "./guichet.js";
import {recupererServices} from "./service.js";

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

function creerAgentDOM(agent) {
    const divAgent=document.createElement("div");
    divAgent.className="divAgent";
    divAgent.dataset.idAgent=agent.idAgent;
    divAgent.innerHTML=creerContenuAgent(agent);
    document.querySelector(".sectionAdminAgent").appendChild(divAgent);
}

function mettreAJourAgentDOM(agent){
const divAgent= document.querySelector(`[data-id-agent='${agent.idAgent}']`)
    if (divAgent) {
        divAgent.innerHTML = '';
        divAgent.innerHTML = creerContenuAgent(agent)
    }
}

function supprimerAgentDOM(agent){
    const divAgent= document.querySelector(`[data-id-agent='${agent.idAgent}']`)
    if (divAgent){
        divAgent.remove();
    }
}

function creerContenuAgent(agent) {
    return `<div>
                <p class="titreServiceAdmin">${agent.nomAgent}</p>
                <p class="nbPersonneAttenteAdmin">${agent.mailAgent}</p>
            </div>
            <div>
                <p>${agent.idGuichet}</p>
            </div>
            <div class="statutAgent">
                <div class="${agent.statutAgent ? "statutTermine" : "statutInactifAdmin"}">${agent.statutAgent ? "Disponible" : "Hors ligne"}</div>
            </div>
            <div class="divListeServices">
                <div class="divStatutAgent">${agent.idService}</div>
            </div>
            <div class="actionsServices">
                <button id="btnModifierService" onclick="modalAgent(
                    '${agent.nomAgent}',
                    '${agent.mailAgent}',
                    ${agent.statutAgent ? 1 : 0},
                    '${agent.loginAgent}',
                    '${agent.motDePasse}',
                    '${agent.roleAgent}',
                    '${agent.idGuichetAgent}',
                    '${agent.idServiceAgent}',
                    () => mettreAJourAgent('${agent.idAgent}'))">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-pen w-4 h-4">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                    </svg>
                </button>
                <button id="btnSupprimerService" onclick="supprimerAgent('${agent.idAgent}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash2 w-4 h-4">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                        <line x1="10" x2="10" y1="11" y2="17"></line>
                        <line x1="14" x2="14" y1="11" y2="17"></line>
                    </svg>
                </button>
            </div>
     `;
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
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourAgentAdministration&controleur=agent", {
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
    mettreAJourStatutAgentOuvert,
    creerAgentDOM,
    mettreAJourAgentDOM,
    supprimerAgentDOM
};