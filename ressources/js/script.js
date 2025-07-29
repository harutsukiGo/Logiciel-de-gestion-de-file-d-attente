async function simuler() {
    const idTicket = document.getElementById("idTicket");
    const numTicket = document.getElementById("numTicketCourant");
    const nomService = document.getElementById("nomServiceCourant");
    const numGuichet = document.getElementById("numeroGuichet");

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
        const divStatut = document.getElementById(`${idTicket.value}`);
        if (divStatut && divStatut.classList.contains("statutEnAttente")) {
            divStatut.textContent = "terminé";
            divStatut.classList.remove("statutEnAttente");
            divStatut.classList.add("statutTermine");
        }
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


async function retourneNbTicketsAttente() {
    return await fetch(`/fileAttente/web/controleurFrontal.php?action=nbTicketsEnAttente&controleur=ticket`, {
        method: "GET"
    })
        .then(response => response.json())
        .then(data => {
            return data;
        });
}

function actualiserHorloge() {
    const horloge = document.getElementById('horloge');
    const maintenant = new Date();
    const jour = maintenant.toLocaleDateString('fr-FR', {weekday: 'long'});
    const numero = maintenant.getDate();
    const mois = maintenant.toLocaleDateString('fr-FR', {month: 'long'});
    const heures = String(maintenant.getHours()).padStart(2, '0');
    const minutes = String(maintenant.getMinutes()).padStart(2, '0');
    const secondes = String(maintenant.getSeconds()).padStart(2, '0');
    horloge.innerHTML = `<p>${jour} ${numero} ${mois}</p>  <p>${heures}:${minutes}:${secondes}</p>`;
}

function afficherPub() {
    const imgPub = document.querySelectorAll('.imgPub');
    let currentIndex = 0;
    setInterval(function () {
        imgPub[currentIndex].classList.remove('active');
        currentIndex = (currentIndex + 1) % imgPub.length;
        imgPub[currentIndex].classList.add('active');
    }, 3000);
}

async function appelerSuivant() {
    const ticket = await recuperePremierTicketAgent();
    if (!ticket || ticket.length === 0) {
        return;
    }
    const div = document.getElementById("infoTicketCourant");
    div.textContent = "";
    let date = new Date();

    await mettreAJourTicket(ticket[0][0], "en cours");
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
        <input type="hidden" id="idTicket" value="${ticket[0][0]}">
         <button id="btnTerminer" onclick="terminerTicket()"> Terminer </button>
         <button id="btnAbsent" onclick="absentTicket()" > Absent </button>
         <button id="btnRappeler" onclick="appelerSuivant()"> Rappeler</button>
        </div>
`);

}

async function terminerTicket() {
    const idTicket = document.getElementById("idTicket");
    if (!idTicket) return;
    await mettreAJourTicket(idTicket.value, "terminé");
    await mettreAJourTicketDateTerminee(idTicket.value);
    reinitialiserInterface();
}

async function absentTicket() {
    const idTicket = document.getElementById("idTicket");
    if (!idTicket) return;
    await mettreAJourTicket(idTicket.value, "absent");
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

function modalService(nomServicePlaceholder, dateOuverturePlaceholder, dateFermeturePlaceholder, checkboxPlaceholder, callback) {
    const modal = document.createElement("div");
    modal.className = "modal";

    const titre = document.createElement("h2");
    titre.textContent = "Nom du service";

    const nomService = document.createElement("input");
    nomService.type = "text";
    nomService.value = nomServicePlaceholder;
    nomService.className = "inputNomService";

    const dateOuverture = document.createElement("input");
    dateOuverture.type = "time";
    dateOuverture.className = "inputTimeOuverture";
    dateOuverture.value = dateOuverturePlaceholder;

    const dateFermeture = document.createElement("input");
    dateFermeture.type = "time";
    dateFermeture.className = "inputTimeFermeture";
    dateFermeture.value = dateFermeturePlaceholder;

    const divParametres = document.createElement("div");
    divParametres.className = "divParametres";
    divParametres.append(nomService, dateOuverture, dateFermeture);

    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.id = "checkboxService";
    checkbox.checked = checkboxPlaceholder;


    const texte = document.createElement("p");
    texte.textContent = "Service actif";

    const divCheckbox = document.createElement("div");
    divCheckbox.className = "divCheckbox";
    divCheckbox.append(checkbox, texte);

    const buttonSave = document.createElement("button");
    buttonSave.id = "buttonSave";
    buttonSave.textContent = "Enregistrer";

    const buttonClose = document.createElement("button");
    buttonClose.id = "buttonClose";
    buttonClose.className = "close";
    buttonClose.textContent = "Annuler";
    buttonClose.onclick = () => {
        modal.remove();
        overlay.remove();
    };
    buttonSave.onclick = async () => {
        await callback();
        modal.remove();
        overlay.remove();
    }


    const divButton = document.createElement("div");
    divButton.className = "divButton";
    divButton.append(buttonSave, buttonClose);

    modal.append(titre, divParametres, divCheckbox, divButton);

    const overlay = document.createElement("div");
    overlay.className = "overlay";
    document.body.append(overlay, modal);
}

async function actualiserListeServices() {
    await fetch("/fileAttente/web/controleurFrontal.php?action=afficherServiceAdministration&controleur=service", {
        method: "GET"
    });
}


async function mettreAJourService(idService) {
    const formData = new FormData();

    const inputNomService = document.querySelector(".inputNomService");
    const inputTimeOuverture = document.querySelector(".inputTimeOuverture");
    const inputTimeFermeture = document.querySelector(".inputTimeFermeture");
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
    const inputNomService = document.querySelector(".inputNomService");
    const inputTimeOuverture = document.querySelector(".inputTimeOuverture");
    const inputTimeFermeture = document.querySelector(".inputTimeFermeture");
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

let htmlInitial;
document.addEventListener("DOMContentLoaded", () => {
    const horloge = document.getElementById("horloge");
    const imgPub = document.querySelectorAll('.imgPub');
    const div = document.getElementById("infoTicketCourant");

    if (horloge && imgPub) {
        afficherPub();
        setInterval(actualiserHorloge, 1000);
        actualiserHorloge();
    }
    if (div) {
        htmlInitial = div.innerHTML;
    }
});
