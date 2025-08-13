import {mettreAJourStatutClient} from "./clients_attente.js";
import {mettreAJourStatutHistorique} from "./historique.js";
import {speech} from "./speech.js";
import {getVoixSelectionnee} from "./parametres.js";

let htmlInitial;

async function appelerSuivant() {
    const ticket = await recuperePremierTicketAgent();
    if (!ticket || ticket.length === 0) {
        return;
    }
    const div = document.getElementById("infoTicketCourant");
    div.textContent = "";
    let date = new Date();
     await mettreAJourTicket(ticket[0].idTicket, "en cours");
    await mettreAJourStatutClient(ticket[0].idTicket, "en cours");
    await mettreAJourStatutHistorique(ticket[0].idHistorique, "en cours");
    await mettreAJourTicketDateArrivee(ticket[0][0]);
    div.style.background = "rgb(239 246 255)";
    div.insertAdjacentHTML("beforeend", `
        <p id="numTicketCourantAgent">${ticket[0].num_ticket}</p>
        <p id="nomServiceCourant">${ticket[0].nomService} </p>
        <p id="statutCourant">En cours</p>
        <p id="dateArrive">Pris à ${date.toLocaleTimeString()} </p>
     `);
    div.insertAdjacentHTML("afterend", `
        <div class="divBoutonStatutTicket">
        <input type="hidden" id="idTicket" value="${ticket[0].idTicket}">
        <input type="hidden" id="idHistorique" value="${ticket[0].idHistorique}">
         <button id="btnTerminer" onclick="terminerTicket()"> Terminer </button>
         <button id="btnAbsent" onclick="absentTicket()" > Absent </button>
            <button id="btnRappeler" onclick="simuler()"> Rappeler </button>
        </div>
    `);
}

function setHtmlInitial(html) {
    htmlInitial = html;
}

async function retourneNbTicketsAttente() {
    return await fetch(`/fileAttente/web/controleurFrontal.php?action=nbTicketsEnAttente&controleur=ticket`, {
        method: "GET"
    })
        .then(response => response.json())
        .then(data => {
            return data;
        });
}

async function terminerTicket() {
    const idTicket = document.getElementById("idTicket");
    const idHistorique = document.getElementById("idHistorique");
    if (!idTicket) return;
    await mettreAJourTicket(idTicket.value, "terminé");
    await mettreAJourStatutClient(idTicket.value, "terminé");
    await mettreAJourStatutHistorique(idHistorique.value, "terminé");
    await mettreAJourTicketDateTerminee(idTicket.value);
    reinitialiserInterface();
}

async function absentTicket() {
    const idTicket = document.getElementById("idTicket");
    const idHistorique = document.getElementById("idHistorique");
    if (!idTicket) return;
    await mettreAJourTicket(idTicket.value, "absent");
    await mettreAJourStatutClient(idTicket.value, "absent");
    await mettreAJourStatutHistorique(idHistorique.value, "absent");
    await mettreAJourTicketDateTerminee(idTicket.value);
    reinitialiserInterface();
}

async function mettreAJourTicket(idTicket, statut) {
    await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutTicket&controleur=ticket&idTicket=${idTicket}&statutTicket=${statut}`, {
        method: "GET"
    })
}

async function recuperePremierTicketAgent() {
    const idAgent = document.getElementById("idAgent");
    const response = await fetch(`/fileAttente/web/controleurFrontal.php?action=recupereTicketAgent&controleur=agent&idAgent=${idAgent.value}`, {
        method: "GET"
    });
    return await response.json();
}

async function mettreAJourTicketDateArrivee(idTicket) {
    if (!idTicket) return;
    try {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourDateArriveeTicket&controleur=ticket&idTicket=${idTicket}`, {
            method: "GET"
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour de la date de début du ticket:", e);
    }
}

async function mettreAJourTicketDateTerminee(idTicket) {
    if (!idTicket) return;
    try {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourDateTermineeTicket&controleur=ticket&idTicket=${idTicket}`, {
            method: "GET"
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour de la date de fin du ticket:", e);
    }
}

async function simuler() {
    const idTicket = document.getElementById("idTicket");
    const numTicket = document.getElementById("numTicketCourantAgent");
    const nomService = document.getElementById("nomServiceCourant");
    const numGuichet = document.getElementById("idGuichetAgent");

     if (!idTicket) {
        if (numTicket) {
            numTicket.textContent = "Aucun tickets à traiter actuellement";
        }
        if (nomService) {
            nomService.textContent = "Aucun service";
        }
        if (numGuichet) {
            numGuichet.textContent = "Aucun guichet";
        }
        return;
    }
     if (await retourneNbTicketsAttente() >= 1) {
        const text = `Le ticket numéro ${numTicket.textContent}, pour le service ${nomService.textContent}, est attendu au guichet numéro ${numGuichet.value}.`;

        let voixSelectionnee = getVoixSelectionnee();
        if (!voixSelectionnee && speechSynthesis.getVoices().length === 0) {
            await new Promise(resolve => {
                speechSynthesis.onvoiceschanged = () => {
                    voixSelectionnee = getVoixSelectionnee();
                    resolve();
                };
                 setTimeout(resolve, 1000);
            });
        }
        if (voixSelectionnee) {
            speech.setText(text);
            speech.setVoice(voixSelectionnee);
            speechSynthesis.cancel();
            speech.speech.volume= parseFloat(localStorage.getItem('speechVolume'));
            speechSynthesis.speak(speech.speech);
        }
    }
}


function reinitialiserInterface() {
    const div = document.getElementById("infoTicketCourant");
    div.innerHTML = htmlInitial;
    div.style.background = "none";
    const divBoutonStatutTicket = document.querySelector(".divBoutonStatutTicket");
    if (divBoutonStatutTicket) {
        divBoutonStatutTicket.remove();
    }
}

async function redirigerTicket() {
    const idTicket = document.getElementById("numTicketRedirection");
    const service = document.getElementById("serviceDeroulant");

    try {
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourServiceClient&controleur=clientAttentes&idTicket=" + idTicket.value + "&idService=" + service.value, {
            method: "GET"
        });
    } catch (e) {
        console.error("Erreur lors de la redirection du ticket");
    }
}

export {
    appelerSuivant,
    terminerTicket,
    absentTicket,
    mettreAJourTicket,
    recuperePremierTicketAgent,
    mettreAJourTicketDateArrivee,
    mettreAJourTicketDateTerminee,
    reinitialiserInterface,
    redirigerTicket,
    retourneNbTicketsAttente,
    setHtmlInitial,
    simuler
};