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

export { actualiserHorloge, afficherPub };