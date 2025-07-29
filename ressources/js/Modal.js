class Modal{

    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.closeButton = this.modal.querySelector('.close');
        this.saveButton = this.modal.querySelector('.save');
        this.cancelButton = this.modal.querySelector('.close');
        this.init();
    }

    init() {
        this.closeButton.addEventListener('click', () => this.close());
        window.addEventListener('click', (event) => {
            if (event.target === this.modal) {
                this.close();
            }
        });
    }

    open() {
        this.modal.style.display = 'block';
    }

    close() {
        this.modal.style.display = 'none';
    }
    createModal(title, content) {
        const divParent = document.createElement('div');
        divParent.className = 'modal-content';
        const h2 = document.createElement('h2');
        h2.textContent = title;
        const buttonSave = document.createElement('button');
        buttonSave.className = 'save';
        const buttonClose = document.createElement('button');
        buttonClose.className = 'close';
        buttonClose.textContent = 'Annuler';
        this.open();
    }
}