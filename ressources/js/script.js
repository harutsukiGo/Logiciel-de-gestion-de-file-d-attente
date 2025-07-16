
async function simuler(){
    const idTicket = document.getElementById("idTicket");
    const numTicket = document.getElementById("numTicketCourant");
    const nomService = document.getElementById("nomServiceCourant");
    const numGuichet = document.getElementById("numeroGuichet");

    if (!idTicket) {
        console.log("Aucun ticket en cours à traiter");
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
            await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutTicket&controleur=ticket&idTicket=${idTicket.value}`, {
                method: "GET"
            })
            await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourTicketCourant&controleur=ticket`, {
                method: "GET"
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.length === 0) {
                        numTicket.textContent ="Aucun tickets à traiter actuellement";
                        nomService.textContent = "Aucun service";
                        numGuichet.textContent = "Aucun guichet";
                    }
                    else{
                        numTicket.textContent = data[0].num_ticket;
                        nomService.textContent = data[0].nomService;
                        numGuichet.textContent = data[0].nom_guichet;
                    }
                });

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

async function retourneNbTicketsAttente() {
    return await fetch(`/fileAttente/web/controleurFrontal.php?action=nbTicketsEnAttente&controleur=ticket`, {
        method: "GET"
    })
        .then(response => response.json())
        .then(data => {
            return data;
        });
}
