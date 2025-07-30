<?php

namespace App\file\Controleur;

use App\file\Lib\ConnexionUtilisateur;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\HistoriqueRepository;
use App\file\Modele\Repository\ServiceRepository;

class ControleurAgent extends ControleurGenerique
{
    public static function afficherAgent()
    {
        $services = (new ServiceRepository())->recuperer();
        $historique = (new HistoriqueRepository())->recupererHistoriqueParAgent($_REQUEST["idAgent"]);
        $tickets = (new AgentRepository())->afficherFileAttente($_REQUEST["idAgent"]);
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Interface Agent",
            "cheminCorpsVue" => "Agent/vueInterfaceAgent.php", "agent" => (new AgentRepository())->recupererParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte()), "tickets" => $tickets, "historique" => $historique,"services" => $services
        ]);
    }

    public static function mettreAJourStatutAgent()
    {
        (new AgentRepository())->mettreAJourStatut(ConnexionUtilisateur::getLoginUtilisateurConnecte(), $_REQUEST["statut"]);
    }

    public static function recupereTicketAgent()
    {
        $ticketAgent = (new AgentRepository())->retournePlusPetitTicketAgent();
        header('Content-Type: application/json');
        echo json_encode($ticketAgent);
    }

    public static function recupererFileAttente()
    {
        (new AgentRepository())->afficherFileAttente(ConnexionUtilisateur::getLoginUtilisateurConnecte());
    }

    public static function afficherAuthentification()
    {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Authentification Agent",
            "cheminCorpsVue" => "Agent/vueAuthentification.php"
        ]);
    }


    public static function connecter()
    {
        if (!isset($_REQUEST['login']) && !isset($_REQUEST['motDePasse'])) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }
        $agent = (new AgentRepository())->recupererParLogin($_REQUEST['login']);
        if (is_null($agent)) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }
        if ($_REQUEST['motDePasse'] !== $agent->getMotDePasse()) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
        }
        ConnexionUtilisateur::connecter($agent->getIdAgent());
        ControleurAgent::redirectionVersURL("?action=afficherDetail&controleur=agent&idAgent=" . $agent->getIdAgent());
    }


    public static function afficherDetail()
    {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Détail Agent",
            "cheminCorpsVue" => "Agent/vueDetail.php",
            "agent" =>  (new AgentRepository())->recupererParClePrimaire($_REQUEST['idAgent'])]);
    }

    public static function deconnecter()
    {
        ConnexionUtilisateur::deconnecter();
        ControleurAgent::redirectionVersURL("?action=afficherAccueil&controleur=accueil");
    }

    public static function afficherListeAgentAdministration()
    {
         $agents = (new AgentRepository())->recuperer();
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Liste des agents - Administration",
            "cheminCorpsVue" => "Agent/listeAgentAdministration.php","agents" => $agents
        ]);
    }

}

