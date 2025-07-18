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
            // await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutTicket&controleur=ticket&idTicket=${idTicket.value}`, {
            //     method: "GET"
            // })
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

async function mettreAJourStatutAgentFermer() {
    const btnFermer = document.getElementById("btnFermer");
    const idAgent = document.getElementById("idAgent");
    try{
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutAgent&controleur=agent&idAgent=${idAgent.value}&statut=${btnFermer.dataset.statut}`, {
            method: "GET"
        });

        const divStatut= document.getElementById("divStatutAgent");
        if (divStatut) {
            divStatut.textContent = "Fermé";
            divStatut.classList.remove("statutAgentOuvert");
            divStatut.classList.add("statutAgentFerme");
        }
    }
    catch (e){
        console.error("Erreur lors de la mise à jour du statut de l'agent.");
    }
}

async function mettreAJourStatutAgentOuvert() {
    const btnOuvert = document.getElementById("btnOuvrir");
    const idAgent = document.getElementById("idAgent");
    try{
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutAgent&controleur=agent&idAgent=${idAgent.value}&statut=${btnOuvert.dataset.statut}`, {
            method: "GET"
        });
        const divStatut= document.getElementById("divStatutAgent");
        if (divStatut) {
            divStatut.textContent = "Ouvert";
            divStatut.classList.remove("statutAgentFerme");
            divStatut.classList.add("statutAgentOuvert");
        }
    }
    catch (e){
        console.error("Erreur lors de la mise à jour du statut de l'agent.");
    }
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
    const maintenant = new Date();
    const jour = maintenant.toLocaleDateString('fr-FR', {weekday: 'long'});
    const numero = maintenant.getDate();
    const mois = maintenant.toLocaleDateString('fr-FR', {month: 'long'});
    const annee = maintenant.getFullYear();
    const heures = String(maintenant.getHours()).padStart(2, '0');
    const minutes = String(maintenant.getMinutes()).padStart(2, '0');
    const secondes = String(maintenant.getSeconds()).padStart(2, '0');

    document.getElementById('horloge').innerHTML = `<p>${jour} ${numero} ${mois}</p>  <p>${heures}:${minutes}:${secondes}</p>`;
}


document.addEventListener("DOMContentLoaded", () => {
    const horloge = document.getElementById('horloge');
    const imgPub = document.querySelectorAll('.imgPub');

    if (horloge && imgPub) {
        let currentIndex = 0;
        setInterval(function () {
            imgPub[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % imgPub.length;
            imgPub[currentIndex].classList.add('active');
        }, 3000);
        setInterval(actualiserHorloge, 1000);
        actualiserHorloge();
    }

});
