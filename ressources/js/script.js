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
    const modal = document.createElement("div");
    modal.className = "modal";

    const titre = document.createElement("h2");
    titre.textContent = "Nouveau service";

    const divNomService=document.createElement("div");
    const nomServiceP= document.createElement("p");
    nomServiceP.textContent= "Nom du service :";

    const nomService = document.createElement("input");
    nomService.type = "text";
    nomService.value = nomServicePlaceholder;
    nomService.className = "inputNomService";

    divNomService.append(nomServiceP,nomService);

    const divDateOuverture= document.createElement("div");
    const dateOuvertureP=document.createElement("p");
    dateOuvertureP.textContent="Horaire d'ouverture :";


    const dateOuverture = document.createElement("input");
    dateOuverture.type = "time";
    dateOuverture.className = "inputTimeOuverture";
    dateOuverture.value = dateOuverturePlaceholder;

    divDateOuverture.append(dateOuvertureP,dateOuverture);


    const divDateFermeture= document.createElement("div");
    const dateFermetureP=document.createElement("p");
    dateFermetureP.textContent="Horaire fermeture :";


    const dateFermeture = document.createElement("input");
    dateFermeture.type = "time";
    dateFermeture.className = "inputTimeFermeture";
    dateFermeture.value = dateFermeturePlaceholder;

    divDateFermeture.append(dateFermetureP,dateFermeture);


    const divParametres = document.createElement("div");
    divParametres.className = "divParametres";
    divParametres.append(divNomService, divDateOuverture, divDateFermeture);

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

 async function modalAgent(nomAgent, mailAgent, statutAgent, loginAgent, motDePasseAgent, roleAgent, idGuichet,idService, callback) {
    const modal = document.createElement("div");
    modal.className = "modal";

    const titre = document.createElement("h2");
    titre.textContent = "Nouvel agent";

    const divNomComplet=document.createElement("div");

    const nomComplet = document.createElement("input");
    nomComplet.type = "text";
    nomComplet.value = nomAgent;
    nomComplet.id = "inputNomAgent";

    const nomCompletP=document.createElement("p");
    nomCompletP.textContent="Nom complet :";

    divNomComplet.append(nomCompletP,nomComplet);

    const divEmail=document.createElement("div");

    const emailP= document.createElement("p");
    emailP.textContent="Email :"

    const email = document.createElement("input");
    email.type = "text";
    email.id = "inputMailAgent";
    email.value = mailAgent;

    divEmail.append(emailP,email);


    const divLogin=document.createElement("div");

    const loginP=document.createElement("p");
    loginP.textContent="Login :"

    const login = document.createElement("input");
    login.type = "text";
    login.id = "inputLoginAgent";
    login.value = loginAgent;

    divLogin.append(loginP,login);

    const divMotDePasse= document.createElement("div");
    const motDePasseP=document.createElement("p");
    motDePasseP.textContent="Mot de passe :";

    const motDePasse = document.createElement("input");
    motDePasse.type = "password";
    motDePasse.id = "inputMotDePasseAgent";
    motDePasse.value = motDePasseAgent;

    divMotDePasse.append(motDePasseP,motDePasse);

    const role = document.createElement("select");
    role.id = "selectRoleAgent";
    role.innerHTML = `
            <option value="agent" ${roleAgent === "agent" ? "selected" : ""}>agent</option>
            <option value="administrateur" ${roleAgent === "administrateur" ? "selected" : ""}>administrateur</option>
        `;

    const roleAgentP = document.createElement("p");
    roleAgentP.textContent = "Rôle agent :";

    const divRole= document.createElement("div");
    divRole.append(roleAgentP,role);

    const divGuichet= document.createElement("div");

    const guichetP= document.createElement("p");
    guichetP.textContent="Guichet :";

    const guichet = document.createElement("select");
    guichet.id = "selectGuichetAgent";
    let guichets = await recupererGuichets();

    guichets.forEach(guichetItem => {
        const option = document.createElement("option");
        option.textContent = guichetItem.idGuichet;
        if (String(guichetItem.idGuichet) === String(idGuichet)) {
             option.selected = true;
        }
        guichet.appendChild(option);
    });

    divGuichet.append(guichetP,guichet);

    const divService = document.createElement("div");
    const serviceP = document.createElement("p");
    serviceP.textContent = "Services :";

    const service = document.createElement("select");
    service.id="selectServicesAgent";
    let services = await recupererServices();

    services.forEach(serviceItem=>{
     const option= document.createElement("option");
     option.value=serviceItem.idService;
     option.textContent=serviceItem.nomService;
     if (String(serviceItem.idService) === String(idService)){
         option.selected=true;
     }
     service.append(option);
    });

    divService.append(serviceP,service);

    const divParametres = document.createElement("div");
    divParametres.className = "divParametres";
    divParametres.append(divNomComplet, divEmail, divLogin, divMotDePasse, divRole, divGuichet, divService);

    const statut = document.createElement("input");
    statut.type = "checkbox";
    statut.id = "checkboxAgent";
    statut.checked = statutAgent;


    const texte = document.createElement("p");
    texte.textContent = "Agent actif";



    const divCheckbox = document.createElement("div");
    divCheckbox.className = "divCheckbox";
    divCheckbox.append(statut, texte);

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

async function mettreAJourAgent(idAgent){
    const formData=new FormData();
    const nomAgent= document.getElementById("inputNomAgent");
    const mailAgent= document.getElementById("inputMailAgent");
    const loginAgent= document.getElementById("inputLoginAgent");
    const motDePasseAgent= document.getElementById("inputMotDePasseAgent");
    const roleAgent= document.getElementById("selectRoleAgent");
    const guichetAgent= document.getElementById("selectGuichetAgent");
    const statutAgent = document.getElementById("checkboxAgent");
    const idServiceAgent=document.getElementById("selectServicesAgent");



    formData.append("idAgent", idAgent);
    formData.append("nomAgent", nomAgent.value);
    formData.append("idAgent",idAgent);
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
    }
    catch (e) {
        console.error("Erreur lors de l'ajout de l'agent");
    }
}

async function ajouterAgent(){
    const formData=new FormData();
    const nomAgent= document.getElementById("inputNomAgent");
    const mailAgent= document.getElementById("inputMailAgent");
    const loginAgent= document.getElementById("inputLoginAgent");
    const motDePasseAgent= document.getElementById("inputMotDePasseAgent");
    const roleAgent= document.getElementById("selectRoleAgent");
    const guichetAgent= document.getElementById("selectGuichetAgent");
    const statutAgent = document.getElementById("checkboxAgent");
    const idServiceAgent=document.getElementById("selectServicesAgent");

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
    }
    catch (e) {
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

// async function actualiserListeServices() {
//     await fetch("/fileAttente/web/controleurFrontal.php?action=afficherServiceAdministration&controleur=service", {
//         method: "GET"
//     });
// }

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

async function supprimerService(idService) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce service ?")) {
        await fetch(`/fileAttente/web/controleurFrontal.php?action=supprimerServiceAdministration&controleur=service&idService=${idService}`, {
            method: "GET"
        });
    }
}

async function augmenterOrdrePub(idPub){
    await fetch(`/fileAttente/web/controleurFrontal.php?action=augmenterOrdre&controleur=publicite&idPublicites=${idPub}`, {
        method: "GET"
    });
}

async function diminuerOrdrePub(idPub){
    await fetch(`/fileAttente/web/controleurFrontal.php?action=diminuerOrdre&controleur=publicite&idPublicites=${idPub}`, {
        method: "GET"
    });
}

function modalPublicite(nomFichierPlaceholder,ordrePlaceholder,statutPlaceholder,typePlaceholder, callback){
    const modal = document.createElement("div");
    modal.className = "modal";

    const titre = document.createElement("h2");
    titre.textContent = "Nouvelle publicité";


    const divNomFichier= document.createElement("div");
    const nomFichierP=document.createElement("p");
    nomFichierP.textContent="URL du fichier :";

    const nomFichier= document.createElement("input");
    nomFichier.type="text";
    nomFichier.id="inputNomFichier";
    nomFichier.value = nomFichierPlaceholder;

    divNomFichier.append(nomFichierP,nomFichier);

    const divOrdre= document.createElement("div");
    const ordreP= document.createElement("p");
    ordreP.textContent="Ordre :";

    const ordre= document.createElement("input");
    ordre.type="number";
    ordre.id="inputOrdre";
    ordre.value = ordrePlaceholder;

    divOrdre.append(ordreP,ordre);

    const divCheckbox = document.createElement("div");
    const statutP=document.createElement("p");
    statutP.textContent="Publicité active :";

    const statut=document.createElement("input");
    statut.type="checkbox";
    statut.id="inputStatut";
    statut.checked= statutPlaceholder;

    divCheckbox.className = "divCheckbox";
    divCheckbox.append(statutP,statut);

    const divType=document.createElement("div");
    const typeP=document.createElement("p");
    typeP.textContent="Type :";

    const type= document.createElement("select");
    type.id="inputType";
    type.innerHTML='' +
        '<option value="image"> image  </option>' +
        '<option value="vidéo"> vidéo </option>';
    type.value= typePlaceholder;
    divType.append(typeP,type);


    const divParametres = document.createElement("div");
    divParametres.className = "divParametres";
    divParametres.append(divNomFichier,divOrdre,divType);


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

    modal.append(titre, divParametres,divCheckbox,divButton);

    const overlay = document.createElement("div");
    overlay.className = "overlay";
    document.body.append(overlay, modal);
}

async function ajouterPublicite(){
    const formData= new FormData();
    const nomFichier=document.getElementById("inputNomFichier");
    const ordre=document.getElementById("inputOrdre");
    const statut= document.getElementById("inputStatut");
    const type=document.getElementById("inputType");

    formData.append("fichier",nomFichier.value);
    formData.append("ordre",ordre.value);
    formData.append("statut",statut.value);
    formData.append("type",type.value);

    try{
        await fetch("/fileAttente/web/controleurFrontal.php?action=creerPubliciteAdministration&controleur=publicite", {
            method: "POST",
            body: formData,
        })
    }
    catch (e) {
        console.error("Erreur lors de l'ajout de la publicité");
    }
}

async function mettreAJourPublicite(idPub) {
    const formData= new FormData();
    const nomFichier=document.getElementById("inputNomFichier");
    const ordre=document.getElementById("inputOrdre");
    const statut= document.getElementById("inputStatut");
    const type=document.getElementById("inputType");

    formData.append("idPublicites", idPub);
    formData.append("fichier",nomFichier.value);
    formData.append("ordre",ordre.value);
    formData.append("statut",statut.value);
    formData.append("type",type.value);

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
