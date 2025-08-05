async function mettreAJourStatutHistorique(idHistorique, statut) {
    try {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=mettreAJourStatutIdHistorique&controleur=historique&idHistorique=${idHistorique}&statut=${statut}`, {
            method: "GET"
        });
    } catch (e) {
        console.error("Erreur lors de la mise à jour du statut de l'historique:", e);
    }
}

export {
    mettreAJourStatutHistorique
}