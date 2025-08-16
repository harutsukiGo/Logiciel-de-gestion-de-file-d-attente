<?php

namespace App\file\Controleur;

use App\file\Lib\ConnexionUtilisateur;
use App\file\Modele\DataObject\ClientAttentes;
use App\file\Modele\DataObject\Historique;
use App\file\Modele\DataObject\Ticket;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\ClientAttentesRepository;
use App\file\Modele\Repository\HistoriqueRepository;
use App\file\Modele\Repository\PubliciteRepository;
use App\file\Modele\Repository\ServiceRepository;
use App\file\Modele\Repository\TicketRepository;
use DateTime;
use DateTimeZone;

class ControleurTicket extends ControleurGenerique
{
    public static function genererTicket()
    {
        if (!isset($_REQUEST['idService'])) {
            return;
        }
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $agent = (new AgentRepository())->recupererParClePrimaire((new ControleurTicket)->recupereAgentRandom());

        $ticket = new Ticket(
            null,
            (new ControleurTicket())->premiereLettre((new ServiceRepository())->recupererParClePrimaire($_REQUEST['idService'])->getNomService()),
            $date,
            "en attente",
            null,
            $agent,
            null,
            null
        );

        $ticketInsere = (new TicketRepository())->ajouterAutoIncrement($ticket);

        if (!$ticketInsere) {
            return;
        }

        $clientAttente = new ClientAttentes(
            null,
            $ticketInsere,
            (new ServiceRepository())->recupererParClePrimaire($_REQUEST['idService']),
            "en attente",
            $date
        );

        $historique = new Historique(
            null,
            "en attente",
            $date,
            "Création du ticket",
            $ticketInsere,
            $agent
        );
        $historiqueInsere = (new HistoriqueRepository())->ajouterAutoIncrement($historique);
        if (!$historiqueInsere) {
            return;
        }
        (new TicketRepository())->mettreAJourHistorique($historiqueInsere, $ticketInsere);
        (new ClientAttentesRepository())->ajouter($clientAttente);

        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Ticket créé",
            "cheminCorpsVue" => "Ticket/genererTicket.php",
            "idService" => $_REQUEST['idService'],
            "ticket" => $ticketInsere,
        ]);
    }


    public static function affichageSalleAttente()
    {
        $publicites = (new PubliciteRepository())->recupererPublicitesActives();
        $service = (new ServiceRepository())->recupererServices();
        $tickets = (new TicketRepository())->recupererTickets();
        $premierTicket = (new TicketRepository())->retournePlusPetitTicket();
        ControleurGenerique::afficherVue('vueIntermediaire.php', [
            "titre" => "Affichage salle d'attente",
            "cheminCorpsVue" => "Ticket/affichageDynamique.php", "service" => $service, "tickets" => $tickets, "premierTicket" => $premierTicket,
            "publicites" => $publicites
        ]);
    }


    public static function nbTicketsEnAttente()
    {
        echo json_encode((new TicketRepository())->recupererNbTicketsEnAttente());
    }

    public static function mettreAJourStatutTicket(): void
    {
        (new TicketRepository())->mettreAJourStatut($_REQUEST['idTicket'], $_REQUEST['statutTicket']);
    }

    public static function mettreAJourDateArriveeTicket()
    {
        (new TicketRepository())->mettreAJourDateArrivee($_REQUEST['idTicket'], new DateTime('now', new DateTimeZone('Europe/Paris')));
    }

    public static function mettreAJourDateTermineeTicket()
    {
        (new TicketRepository())->mettreAJourDateTerminee($_REQUEST['idTicket'], new DateTime('now', new DateTimeZone('Europe/Paris')));
    }

    public static function mettreAJourTicketCourant(): void
    {
        $premierTicket = (new TicketRepository())->retournePlusPetitTicket();
        header('Content-Type: application/json');
        echo json_encode($premierTicket);
    }

    public static function premiereLettre(string $chaine): string
    {
        return strtoupper($chaine[0]) . str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
    }

    public static function recupereAgentRandom()
    {
        $agents = (new AgentRepository())->recupererAgentActif();

        if (empty($agents)) {
            return null;
        }

        $randomIndex = random_int(0, count($agents) - 1);
        return $agents[$randomIndex]->getIdAgent();
    }

    public static function compterClientServi(): int
    {
        return (new TicketRepository())->compterNombreClient(ConnexionUtilisateur::getIdAgentConnecte());
    }

}