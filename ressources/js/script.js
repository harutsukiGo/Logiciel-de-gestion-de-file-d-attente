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
        try {

            // await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourTicketCourant&controleur=ticket`, {
            //     method: "GET"
            // })
            //     .then(response => {
            //         if (!response.ok) {
            //             throw new Error(`Erreur HTTP: ${response.status}`);
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         if (data.length === 0) {
            //             numTicket.textContent ="Aucun tickets à traiter actuellement";
            //             nomService.textContent = "Aucun service";
            //             numGuichet.textContent = "Aucun guichet";
            //         }
            //         else{
            //             numTicket.textContent = data[0].num_ticket;
            //             nomService.textContent = data[0].nomService;
            //             numGuichet.textContent = data[0].nom_guichet;
            //         }
            //     });

            const divStatut = document.getElementById(`${idTicket.value}`);
            if (divStatut && divStatut.classList.contains("statutEnAttente")) {
                divStatut.textContent = "terminé";
                divStatut.classList.remove("statutEnAttente");
                divStatut.classList.add("statutTermine");
            }

        } catch (e) {
            console.error("Erreur : ", e);

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
