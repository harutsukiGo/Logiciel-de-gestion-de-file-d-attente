class Speech {
    constructor() {
        this.speech = new SpeechSynthesisUtterance("");
        this.speech.volume = parseFloat(localStorage.getItem('speechVolume') || 1);
     }

    setText(texte) {
        this.speech.text = texte;
    }

    setVolume(valeur) {
        this.speech.volume = parseFloat(valeur);
        localStorage.setItem('speechVolume', this.speech.volume);
    }
    setVoice(voice) {
        this.speech.voice = voice;
    }
}

const speech = new Speech();

export {
    speech
}