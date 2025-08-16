import {actualiserHorloge, afficherPub, ajusterVolume, initialiserSliderVolume} from './utils.js';
import {
    modalAgent,
    mettreAJourAgent,
    ajouterAgent,
    supprimerAgent,
    mettreAJourStatutAgentFermer,
    mettreAJourStatutAgentOuvert,
    creerAgentDOM,
    mettreAJourAgentDOM,
    supprimerAgentDOM
} from './agent.js';

import {
    modalService,
    ajouterService,
    mettreAJourService,
    supprimerService,
    ajouterServiceAuDOM,
    mettreAJourServiceDansDOM,
    supprimerServiceDuDOM
} from './service.js';

import {
    appelerSuivant,
    terminerTicket,
    absentTicket,
    mettreAJourTicket,
    recuperePremierTicketAgent,
    mettreAJourTicketDateArrivee,
    mettreAJourTicketDateTerminee,
    reinitialiserInterface,
    redirigerTicket,
    retourneNbTicketsAttente,
    setHtmlInitial,
    simuler
} from './ticket.js';

import {
    modalGuichet,
    ajouterGuichet,
    mettreAJourGuichet,
    supprimerGuichet
} from './guichet.js';

import {
    modalPublicite,
    ajouterPublicite,
    mettreAJourPublicite,
    supprimerPublicite,
    diminuerOrdrePub, augmenterOrdrePub
} from './publicite.js';

import {
    afficherVoix, mettreAJourParametres
} from './parametres.js'


window.modalPublicite = modalPublicite;
window.ajouterPublicite = ajouterPublicite;
window.mettreAJourPublicite = mettreAJourPublicite;
window.supprimerPublicite = supprimerPublicite;
window.diminuerOrdrePub = diminuerOrdrePub;
window.augmenterOrdrePub = augmenterOrdrePub;

window.modalGuichet = modalGuichet;
window.ajouterGuichet = ajouterGuichet;
window.mettreAJourGuichet = mettreAJourGuichet;
window.supprimerGuichet = supprimerGuichet;

window.modalAgent = modalAgent;
window.mettreAJourAgent = mettreAJourAgent;
window.ajouterAgent = ajouterAgent;
window.supprimerAgent = supprimerAgent;
window.mettreAJourStatutAgentFermer = mettreAJourStatutAgentFermer;
window.mettreAJourStatutAgentOuvert = mettreAJourStatutAgentOuvert;
window.creerAgentDOM = creerAgentDOM;
window.mettreAJourAgentDOM=mettreAJourAgentDOM;
window.supprimerAgentDOM=supprimerAgentDOM;


window.appelerSuivant = appelerSuivant;
window.terminerTicket = terminerTicket;
window.absentTicket = absentTicket;
window.redirigerTicket = redirigerTicket;
window.simuler = simuler;
window.mettreAJourTicket = mettreAJourTicket;
window.recuperePremierTicketAgent = recuperePremierTicketAgent;
window.mettreAJourTicketDateArrivee = mettreAJourTicketDateArrivee
window.mettreAJourTicketDateTerminee = mettreAJourTicketDateTerminee;
window.reinitialiserInterface = reinitialiserInterface;
window.retourneNbTicketsAttente = retourneNbTicketsAttente;
window.setHtmlInitial = setHtmlInitial;


window.modalService = modalService;
window.ajouterService = ajouterService;
window.mettreAJourService = mettreAJourService;
window.supprimerService = supprimerService;
window.ajouterServiceAuDOM = ajouterServiceAuDOM;
window.mettreAJourServiceDansDOM = mettreAJourServiceDansDOM;
window.supprimerServiceDuDOM = supprimerServiceDuDOM;

window.ajusterVolume = ajusterVolume;
window.initialiserSliderVolume = initialiserSliderVolume;

window.afficherVoix = afficherVoix;
window.mettreAJourParametres = mettreAJourParametres;

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
        setHtmlInitial(div.innerHTML);
    }

    afficherVoix();
    initialiserSliderVolume();
    const pusherService = new Pusher('da5a8b9ef5f31e2a1ad8', {
        cluster: 'eu',
        encrypted: true
    });

    const pusherAgent = new Pusher('d7bb9117b19bb62a9a43', {
        cluster:'eu',
        encrypted: true
    });

    const servicesChannel = pusherService.subscribe('service-channel');
    const agentsChennel = pusherAgent.subscribe('agent-channel');

    servicesChannel.bind('service-cree', function (data) {
        console.log('Événement service-cree reçu:', data);
        ajouterServiceAuDOM(data);
    });

    servicesChannel.bind('service-modifiee', function (data) {
        console.log('service-modifee:', data);
        mettreAJourServiceDansDOM(data);
    });

    servicesChannel.bind('service-supprime', function (data) {
        console.log('service-supprime:', data);
        supprimerServiceDuDOM(data);
    });

    agentsChennel.bind('agent-cree',function (data){
        console.log('agent cree',data);
        creerAgentDOM(data);
    });

    agentsChennel.bind('agent-modifiee',function (data){
        console.log('agent modifie',data);
        mettreAJourAgentDOM(data);
    });

    agentsChennel.bind('agent-supprime',function (data){
        console.log('agent suprime',data);
        supprimerAgentDOM(data);
    });
});
