class Modal {

    constructor(titre) {
        this.modal = document.createElement("div");
        this.modal.className = "modal";

        this.overlay = document.createElement("div");
        this.overlay.className = "overlay";

        this.setTitre(titre);

        this.divParametres = document.createElement("div");
        this.divParametres.className = "divParametres";
        this.modal.appendChild(this.divParametres);

     }


    setTitre(texte) {
        const titre = document.createElement("h2");
        titre.textContent = texte;
        this.modal.prepend(titre);
        return this;
    }

    creerButtons(callback) {
        const buttonSave = document.createElement("button");
        buttonSave.id = "buttonSave";
        buttonSave.textContent = "Enregistrer";

        const buttonClose = document.createElement("button");
        buttonClose.id = "buttonClose";
        buttonClose.className = "close";
        buttonClose.textContent = "Annuler";

        buttonClose.onclick = () => {
            this.fermer();
        };

        buttonSave.onclick = async () => {
            await callback();
            this.fermer();
        }
        const divButton = document.createElement("div");
        divButton.className = "divButton";
        divButton.append(buttonSave, buttonClose);
        this.modal.append(divButton);
        return this;
    }

    fermer() {
        this.modal.remove();
        this.overlay.remove();
        return this;
    }


    creerTextField(titre,type,nomObjetPlaceholder,objet){
        const divObjet=document.createElement("div");
        const nomObjetTitre= document.createElement("p");
        nomObjetTitre.textContent=`${titre} : `;

        const nomObjet = document.createElement("input");
        nomObjet.type =type;
        nomObjet.value = nomObjetPlaceholder;
        nomObjet.id = `input${objet}`;

        divObjet.append(nomObjetTitre,nomObjet);
        this.divParametres.append(divObjet);
        return this;
    }

    creerInputCheckbox(titre,nomObjetPlaceholder,objet){
        const divObjetCheckbox = document.createElement("div");
        divObjetCheckbox.className = "divCheckbox";

        const nomObjetCheckbox = document.createElement("p");
        nomObjetCheckbox.textContent =titre;

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.id = `checkbox${objet}`;
        checkbox.checked = nomObjetPlaceholder;

        divObjetCheckbox.append(checkbox,nomObjetCheckbox);
        this.modal.append(divObjetCheckbox);
        return this;
    }


    async creerInputSelect(titre, objet, idObjet, callback) {
        const divObjetSelect = document.createElement("div");

        const nomObjetSelect = document.createElement("p");
        nomObjetSelect.textContent = `${titre} :`;

        const select = document.createElement("select");
        select.id = objet;
        let tab = await callback();

        tab.forEach(selectItem => {
            const option = document.createElement("option");
             const valeur = selectItem.idGuichet || selectItem.idService || selectItem.idObjet;
            option.value = valeur;

            if (selectItem.nomService) {
                option.textContent = selectItem.nomService;
            }
            else {
                option.textContent = valeur;
            }

            if (String(valeur) === String(idObjet)) {
                option.selected = true;
            }
            select.appendChild(option);
        });

        divObjetSelect.append(nomObjetSelect, select);
        this.divParametres.append(divObjetSelect);
        return this;
    }


    creerSelecteur(titre, id, options, valeurSelectionnee = null) {
        const divSelect = document.createElement("div");

        const labelSelect = document.createElement("p");
        labelSelect.textContent = `${titre} :`;

        const select = document.createElement("select");
        select.id = id;

        options.forEach(option => {
            const optionElement = document.createElement("option");
            optionElement.value = option.valeur;
            optionElement.textContent = option.texte;

            if (valeurSelectionnee !== null && option.valeur === valeurSelectionnee) {
                optionElement.selected = true;
            }

            select.appendChild(optionElement);
        });

        divSelect.append(labelSelect, select);
        this.divParametres.appendChild(divSelect);

        return this;
    }


      afficher(){
        document.body.append(this.overlay, this.modal);
        return this;
    }



}