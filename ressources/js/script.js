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
<!--         <button id="btnRappeler" onclick="appelerSuivant()"> Rappeler</button>-->
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
    const modal = new Modal("Nouveau service");
    modal.creerTextField("Nom du service", "text", nomServicePlaceholder, "NomService");
    modal.creerTextField("Horaire d'ouverture", "time", dateOuverturePlaceholder, "TimeOuverture");
    modal.creerTextField("Horaire de fermeture", "time", dateFermeturePlaceholder, "TimeFermeture");
    modal.creerInputCheckbox("Service actif", checkboxPlaceholder, "Service");
    modal.creerButtons(callback);
    modal.afficher();
}

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


async function recupererGuichets() {
    const response = await fetch("/fileAttente/web/controleurFrontal.php?action=recupererListeGuichet&controleur=guichet", {
        method: "GET"
    })
    return await response.json();
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
