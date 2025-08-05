import { actualiserHorloge, afficherPub } from './utils.js';
import {
    modalAgent,
    mettreAJourAgent,
    ajouterAgent,
    supprimerAgent,
    mettreAJourStatutAgentFermer,
    mettreAJourStatutAgentOuvert
} from './agent.js';

import {
    modalService,
    ajouterService,
    mettreAJourService,
    supprimerService,
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

import { modalPublicite, ajouterPublicite, mettreAJourPublicite, supprimerPublicite } from './publicite.js';



window.modalPublicite = modalPublicite;
window.ajouterPublicite = ajouterPublicite;
window.mettreAJourPublicite = mettreAJourPublicite;
window.supprimerPublicite = supprimerPublicite;

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
});
