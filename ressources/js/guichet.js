import { Modal } from "./modal.js";
import { recupererServices } from "./service.js";

async function recupererGuichets() {
    const response = await fetch("/fileAttente/web/controleurFrontal.php?action=recupererListeGuichet&controleur=guichet", {
        method: "GET"
    })
    return await response.json();
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

export { modalGuichet, ajouterGuichet, mettreAJourGuichet, supprimerGuichet, recupererGuichets };