function afficherVoix() {
    const divSelectParametre = document.querySelector(".divSelectVoix");
    if (!divSelectParametre) return;

    const select = document.createElement("select");
    select.id = "selectVoices";
    divSelectParametre.appendChild(select);

    function remplirSelect() {
        const voices = window.speechSynthesis.getVoices();
        select.innerHTML = "";

        voices.forEach((voice, i) => {
            if (voice.lang === "fr-FR") {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = voice.name + " (" + voice.lang + ")";
                select.appendChild(option);
            }
        });

        const savedVoice = localStorage.getItem("voixSelectionnee");
        if (savedVoice) {
            select.value = savedVoice;
        }
    }

    select.addEventListener("change", function () {
        localStorage.setItem("voixSelectionnee", this.value);
    });

    if (speechSynthesis.getVoices().length > 0) {
        remplirSelect();
    }

    speechSynthesis.onvoiceschanged = remplirSelect;
}

function getVoixSelectionnee() {
    const voices = speechSynthesis.getVoices();
    const indexVoix = parseInt(localStorage.getItem("voixSelectionnee"), 10);

    if (!isNaN(indexVoix) && indexVoix >= 0 && indexVoix < voices.length) {
        return voices[indexVoix];
    }
    return null;
}


async function mettreAJourParametres(){
    const nomOrganisation=document.getElementById("nomOrganisation");
    const ouverture=document.getElementById("ouvertureParametres");
    const fermeture = document.getElementById("fermetureParametres");

    const formData = new FormData();

    formData.append("nom_organisation",nomOrganisation.value);
    formData.append("heure_ouverture",ouverture.value);
    formData.append("heure_fermeture",fermeture.value);

    try{
        await fetch("/fileAttente/web/controleurFrontal.php?action=mettreAJourParametres&controleur=parametre", {
            method: "POST",
            body:formData
        });

    }
    catch (e){
        console.error("Erreur lors de la mise à jour des paramètres :", e);
     }

}

export {afficherVoix, getVoixSelectionnee,mettreAJourParametres}