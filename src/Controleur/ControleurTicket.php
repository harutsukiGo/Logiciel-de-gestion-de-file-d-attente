<?php

namespace App\file\Controleur;

use App\file\Controleur\ControleurGenerique;
use App\file\Modele\DataObject\Agents;
use App\file\Modele\DataObject\ClientAttentes;
use App\file\Modele\DataObject\Historique;
use App\file\Modele\DataObject\Ticket;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\ClientAttentesRepository;
use App\file\Modele\Repository\HistoriqueRepository;
use App\file\Modele\Repository\ServiceRepository;
use App\file\Modele\Repository\TicketRepository;

class ControleurTicket extends ControleurGenerique
{
    public function genererTicket()
    {
        if (!isset($_REQUEST['idService'])) {
            return;
        }
        $date = new \DateTime('now');
        $agent = (new AgentRepository())->recupererParClePrimaire($this->recupereAgentRandom());

        $ticket = new Ticket(
            null,
            $this->premiereLettre((new ServiceRepository())->getNomService($_REQUEST['idService'])),
            $date,
            "en attente",
            null,
            $agent
        );

        $ticketInsere = (new TicketRepository())->ajouterTicket($ticket);
        if (!$ticketInsere) {
            return;
        }

        $clientAttente= new ClientAttentes(
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
        $historiqueInsere= (new HistoriqueRepository())->ajouterHistorique($historique);
        if (!$historiqueInsere) {
            return;
        }
        (new TicketRepository())->mettreAJourHistorique($historiqueInsere, $ticketInsere);
        (new ClientAttentesRepository())->ajouterClientAttentes($clientAttente);

        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Ticket créé",
            "cheminCorpsVue" => "Ticket/genererTicket.php",
            "idService" => $_REQUEST['idService'],
            "ticket" => $ticketInsere,
        ]);
    }

    public function premiereLettre(string $chaine): string
    {
        return strtoupper($chaine[0]) . str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
    }

    public function recupereAgentRandom()
    {
        $agents = (new AgentRepository())->recuperer();

        if (empty($agents)) {
            return null;
        }

        $randomIndex = random_int(0, count($agents) - 1);
        return $agents[$randomIndex]->getIdAgent();
    }

}