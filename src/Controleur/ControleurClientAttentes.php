<?php

namespace App\file\Controleur;

use App\file\Configuration\Ticket\PusherTicket;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\ClientAttentesRepository;
use App\file\Modele\Repository\ServiceRepository;
use App\file\Modele\Repository\TicketRepository;

class ControleurClientAttentes extends ControleurGenerique
{
    public static function mettreAJourServiceClient()
    {

        $pusher = new PusherTicket();
        $nbAgent = (new AgentRepository())->retourneNbAgentParService($_REQUEST['idService']);

        if ($nbAgent >= 2 || $nbAgent == 0) {
            $agent = (new AgentRepository())->recupererParClePrimaire((new ControleurTicket())->recupereAgentRandom());
        } else {
            $agent = (new AgentRepository())->recupererParClePrimaire((new AgentRepository())->retourneAgentPourUnService($_REQUEST['idService']));
        }

        $pusher->trigger("ticket-channel", "ticket-supprimeRedirige", [
            "idTicket" => $_REQUEST["idTicket"],
          ]);

        (new ClientAttentesRepository())->mettreAJourService($_REQUEST["idTicket"], $_REQUEST["idService"]);


        (new TicketRepository())->mettreAJourAgent($agent,$_REQUEST["idTicket"]);

        $pusher->trigger("ticket-channel", "ticket-redirige", [
                "idTicket" => $_REQUEST["idTicket"],
                "idAgent" => $agent->getIdAgent(),
                "nomService" => (new ServiceRepository())->recupererParClePrimaire($_REQUEST["idService"])->getNomService(),
                "numTicket" => (new TicketRepository())->recupererParClePrimaire( $_REQUEST["idTicket"])->getNumTicket(),
            ]);
    }

    public static function mettreAJourStatutClient()
    {
        (new ClientAttentesRepository())->mettreAJourStatut($_REQUEST["idTicket"], $_REQUEST["statut"]);

    }
}