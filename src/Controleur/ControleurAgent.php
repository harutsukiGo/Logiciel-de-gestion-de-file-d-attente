<?php
namespace App\file\Controleur;

use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\TicketRepository;

class ControleurAgent extends ControleurGenerique
{
    public function afficherAgent()
    {
        $premierTicket = (new AgentRepository())->retournePlusPetitTicketAgent();
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Interface Agent",
            "cheminCorpsVue" => "Agent/vueInterfaceAgent.php","agent" => (new AgentRepository())->recupererParClePrimaire($_REQUEST["idAgent"]),"premierTicket" => $premierTicket
        ]);
    }

    public function mettreAJourStatutAgent()
    {
        (new AgentRepository())->mettreAJourStatut($_REQUEST["idAgent"],$_REQUEST["statut"]);
    }
}