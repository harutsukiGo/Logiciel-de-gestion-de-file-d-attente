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
    simuler,
    mettreAJourFileAttente,
    supprimerTicket,
    afficherTicketCourant
} from './ticket.js';

import {
    modalGuichet,
    ajouterGuichet,
    mettreAJourGuichet,
    supprimerGuichet,
    ajouterGuichetAuDOM,
    mettreAJourGuichetAuDOM,
    supprimerGuichetDuDOM,
} from './guichet.js';

import {
    modalPublicite,
    ajouterPublicite,
    mettreAJourPublicite,
    supprimerPublicite,
    diminuerOrdrePub,
    augmenterOrdrePub,
    ajouterPubAuDOM,
    mettreAJourPubDOM,
    supprimerPubDuDOM,
    changerOrdrePubDuDOM
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
window.ajouterPubAuDOM = ajouterPubAuDOM;
window.mettreAJourPubDOM=mettreAJourPubDOM;
window.supprimerPubDuDOM=supprimerPubDuDOM;
window.augmenterOrdrePubDuDOM=changerOrdrePubDuDOM;

window.modalGuichet = modalGuichet;
window.ajouterGuichet = ajouterGuichet;
window.mettreAJourGuichet = mettreAJourGuichet;
window.supprimerGuichet = supprimerGuichet;
window.ajouterGuichetAuDOM=ajouterGuichetAuDOM;
window.mettreAJourGuichetAuDOM=mettreAJourGuichetAuDOM;
window.supprimerGuichetDuDOM=supprimerGuichetDuDOM;

window.modalAgent = modalAgent;
window.mettreAJourAgent = mettreAJourAgent;
window.ajouterAgent = ajouterAgent;
window.supprimerAgent = supprimerAgent;
window.mettreAJourStatutAgentFermer = mettreAJourStatutAgentFermer;
window.mettreAJourStatutAgentOuvert = mettreAJourStatutAgentOuvert;
window.creerAgentDOM = creerAgentDOM;
window.mettreAJourAgentDOM = mettreAJourAgentDOM;
window.supprimerAgentDOM = supprimerAgentDOM;


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
window.mettreAJourFileAttente=mettreAJourFileAttente;
window.supprimerTicket=supprimerTicket;
window.afficherTicketCourant=afficherTicketCourant;

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
        cluster: 'eu',
        encrypted: true
    });

    const pusherPublicite = new Pusher('cbb5eb4a126a9d026d02', {
        cluster: 'eu',
        encrypted: true
    });

    const pusherGuichet=new Pusher('af1fa86b0285d98a104e',{
        cluster: 'eu',
        encrypted: true
    });

    const pusherTicket=new Pusher('0113c2d38580481c73f9', {
        cluster: 'eu',
        encrypted: true
    })

    const servicesChannel = pusherService.subscribe('service-channel');
    const agentsChennel = pusherAgent.subscribe('agent-channel');
    const publiciteChannel = pusherPublicite.subscribe('publicite-channel');
    const guichetChannel=pusherGuichet.subscribe('guichet-channel');
    const ticketChannel= pusherTicket.subscribe('ticket-channel');

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

    agentsChennel.bind('agent-cree', function (data) {
        console.log('agent cree', data);
        creerAgentDOM(data);
    });

    agentsChennel.bind('agent-modifiee', function (data) {
        console.log('agent modifie', data);
        mettreAJourAgentDOM(data);
    });

    agentsChennel.bind('agent-supprime', function (data) {
        console.log('agent suprime', data);
        supprimerAgentDOM(data);
    });

    publiciteChannel.bind('publicite-cree', function (data) {
        console.log('publicite-cree:', data);
        ajouterPubAuDOM(data);
    })

    publiciteChannel.bind('publicite-modifiee', function (data) {
        console.log('publicite-modife:', data);
        mettreAJourPubDOM(data);
    })

    publiciteChannel.bind('publicite-supprime', function (data) {
        console.log('publicite-supprime:', data);
        supprimerPubDuDOM(data)
    });

    publiciteChannel.bind('publicite-augmente', function (data) {
        console.log('publicite-augmente:', data);
        changerOrdrePubDuDOM(data);
    })

    publiciteChannel.bind('publicite-diminue', function (data) {
        console.log('publicite-diminue:', data);
        changerOrdrePubDuDOM(data);
    })

    guichetChannel.bind('guichet-cree', function (data) {
        console.log('guichet-cree:', data);
        ajouterGuichetAuDOM(data);
    })

    guichetChannel.bind('guichet-modifiee', function (data) {
        console.log('guichet-modifiee:', data);
        mettreAJourGuichetAuDOM(data);
    })

    guichetChannel.bind('guichet-supprime', function (data) {
        console.log('guichet-supprime:', data);
        supprimerGuichetDuDOM(data);
    })

    ticketChannel.bind('ticket-cree', function (data) {
        console.log('ticket-cree:', data);
        mettreAJourFileAttente(data);
    })
    ticketChannel.bind('ticket-termine', function (data) {
        console.log('ticket-suprime:', data);
        supprimerTicket(data);
    })

    ticketChannel.bind('ticket-redirige', function (data) {
        console.log('ticket-modifie:', data);
        mettreAJourFileAttente(data);
    })

    ticketChannel.bind('ticket-supprimeRedirige', function (data) {
        console.log('suppression du ticket initial:', data);
        supprimerTicket(data);
    })
    ticketChannel.bind('ticket-affichage', function (data) {
        console.log('Nouveau ticket courant', data);
        afficherTicketCourant(data);
    })
});
