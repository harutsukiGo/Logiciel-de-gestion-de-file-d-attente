
async function mettreAJourStatutClient(idTicket, statut) {
     try {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutClient&controleur=clientAttentes&idTicket=${idTicket}&statut=${statut}`, {
            method: "GET"
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour du statut du client:", e);
    }
}


export {
    mettreAJourStatutClient
}