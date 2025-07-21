<?php
namespace App\file\Controleur;

use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\HistoriqueRepository;

class ControleurAgent extends ControleurGenerique
{
    public function afficherAgent()
    {
        $historique = (new HistoriqueRepository())->recupererHistoriqueParAgent($_REQUEST["idAgent"]);
        $tickets= (new AgentRepository())->afficherFileAttente($_REQUEST["idAgent"]);
         ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Interface Agent",
            "cheminCorpsVue" => "Agent/vueInterfaceAgent.php","agent" => (new AgentRepository())->recupererParClePrimaire($_REQUEST["idAgent"]),"tickets" =>$tickets, "historique" => $historique
        ]);
    }

    public function mettreAJourStatutAgent()
    {
        (new AgentRepository())->mettreAJourStatut($_REQUEST["idAgent"],$_REQUEST["statut"]);
    }

    public function recupereTicketAgent()
    {
        $ticketAgent=(new AgentRepository())->retournePlusPetitTicketAgent();
        header('Content-Type: application/json');
        echo json_encode($ticketAgent);
    }

    public function recupererFileAttente()
    {
        (new AgentRepository())->afficherFileAttente($_REQUEST["idAgent"]);
    }
}

