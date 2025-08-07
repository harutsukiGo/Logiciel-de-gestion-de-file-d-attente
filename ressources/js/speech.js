class Speech {
    constructor() {
        this.speech = new SpeechSynthesisUtterance("");
        this.speech.volume = parseFloat(localStorage.getItem('speechVolume') || 1);
        this.speech.voice = null;
    }

    setText(texte) {
        this.speech.text = texte;
    }

    setVolume(valeur) {
        this.speech.volume = parseFloat(valeur);
        localStorage.setItem('speechVolume', this.speech.volume);
    }
    getVolume() {
        return this.speech.volume;
    }

    parler() {
        window.speechSynthesis.speak(this.speech);
    }
}

const speech = new Speech();

export {
    speech
}