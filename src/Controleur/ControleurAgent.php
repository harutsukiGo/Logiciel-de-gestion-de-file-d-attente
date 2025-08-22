<?php

namespace App\file\Controleur;

use App\file\Configuration\Agent\PusherAgent;
use App\file\Lib\ConnexionAgent;
use App\file\Lib\MotDePasse;
use App\file\Modele\DataObject\Agents;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\GuichetsRepository;
use App\file\Modele\Repository\HistoriqueRepository;
use App\file\Modele\Repository\ServiceRepository;

class ControleurAgent extends ControleurGenerique
{
    public static function afficherAgent()
    {
        $services = (new ServiceRepository())->recupererServices();
        $historique = (new HistoriqueRepository())->recupererHistoriqueParAgent($_REQUEST["idAgent"]);
        $tickets = (new AgentRepository())->afficherFileAttente($_REQUEST["idAgent"]);
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Interface Agent",
            "cheminCorpsVue" => "Agent/vueInterfaceAgent.php", "agent" => (new AgentRepository())->recupererParClePrimaire(ConnexionAgent::getIdAgentConnecte()), "tickets" => $tickets, "historique" => $historique, "services" => $services
        ]);
    }

    public static function mettreAJourStatutAgent()
    {
        (new AgentRepository())->mettreAJourStatut(ConnexionAgent::getIdAgentConnecte(), $_REQUEST["statut"]);
    }

    public static function recupereTicketAgent()
    {
        $ticketAgent = (new AgentRepository())->retournePlusPetitTicketAgent();
        header('Content-Type: application/json');
        echo json_encode($ticketAgent);
    }

    public static function recupererFileAttente()
    {
        (new AgentRepository())->afficherFileAttente(ConnexionAgent::getIdAgentConnecte());
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
        if (!isset($_REQUEST['login']) || !isset($_REQUEST['motDePasse'])) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }
        $agent = (new AgentRepository())->recupererParLogin($_REQUEST['login']);

        if (is_null($agent)) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }

        if (!MotDePasse::verifier($_REQUEST['motDePasse'], $agent->getMotDePasse())) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }
        ConnexionAgent::connecter($agent->getIdAgent());

        ControleurAgent::redirectionVersURL("?action=afficherDetail&controleur=agent&idAgent=" . $agent->getIdAgent());
    }


    public static function afficherDetail()
    {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Détail Agent",
            "cheminCorpsVue" => "Agent/vueDetail.php",
            "agent" => (new AgentRepository())->recupererParClePrimaire($_REQUEST['idAgent'])]);
    }

    public static function deconnecter()
    {
        ConnexionAgent::deconnecter();
        ControleurAgent::redirectionVersURL("?action=afficherAccueil&controleur=accueil");
    }

    public static function afficherListeAgentAdministration()
    {
        $agents = (new AgentRepository())->recuperer();
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Liste des agents - Administration",
            "cheminCorpsVue" => "Agent/listeAgentAdministration.php", "agents" => $agents
        ]);
    }

    public static function creerAgentAdministration()
    {
        $nomAgent = $_POST["nomAgent"];
        $emailAgent = $_POST["mailAgent"];
        $loginAgent = $_POST["loginAgent"];
        $motDePasseAgent = MotDePasse::hacher($_POST["motDePasseAgent"]);
        $roleAgent = $_POST["roleAgent"];
        $guichetAgent = (new GuichetsRepository())->recupererParClePrimaire($_POST["idGuichet"]);
        $idService = (new ServiceRepository())->recupererParClePrimaire($_POST["idService"]);
        $statutAgent = $_POST["statutAgent"];

        $agent = new Agents(null, $nomAgent, $emailAgent, $statutAgent, $loginAgent, $motDePasseAgent, $roleAgent, $guichetAgent, $idService,1);

        $agentCree = (new AgentRepository())->ajouterAutoIncrement($agent);

        if (!$agentCree) {
            header('Content-Type: application/json');
            echo json_encode(['failed' => false, 'message' => 'Erreur lors de la création de l\'agent.']);
            exit;
        }

        $pusher = new PusherAgent();
        $pusher->trigger('agent-channel', 'agent-cree', [
            'idAgent' => $agentCree->getIdAgent(),
            'nomAgent' => $agentCree->getNomAgent(),
            'mailAgent' => $agentCree->getMailAgent(),
            'statutAgent' => $agentCree->getStatut(),
            'loginAgent' => $agentCree->getLogin(),
            'motDePasse' => $agentCree->getMotDePasse(),
            'roleAgent' => $agentCree->getRole(),
            'idGuichet' => $guichetAgent->getNomGuichet(),
            'idService' => $idService->getNomService(),
            'estActif' => $agentCree->getEstActif()
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;

    }

    public static function mettreAJourAgentAdministration()
    {
        $idAgent = $_POST["idAgent"];
        $nomAgent = $_POST["nomAgent"];
        $emailAgent = $_POST["mailAgent"];
        $loginAgent = $_POST["loginAgent"];
        $motDePasseAgent = MotDePasse::hacher($_POST["motDePasseAgent"]);
        $roleAgent = $_POST["roleAgent"];
        $guichetAgent = (new GuichetsRepository())->recupererParClePrimaire($_POST["idGuichet"]);
        $statutAgent = $_POST["statutAgent"];
        $idServiceAgent = (new ServiceRepository())->recupererParClePrimaire($_POST["idService"]);

        $agent = new Agents ($idAgent, $nomAgent, $emailAgent, $statutAgent, $loginAgent, $motDePasseAgent, $roleAgent, $guichetAgent, $idServiceAgent,1);

        (new AgentRepository())->mettreAJour($agent);


        $pusher = new PusherAgent();
        $pusher->trigger('agent-channel', 'agent-modifiee', [
            'idAgent' => $agent->getIdAgent(),
            'nomAgent' => $agent->getNomAgent(),
            'mailAgent' => $agent->getMailAgent(),
            'statutAgent' => $agent->getStatut(),
            'loginAgent' => $agent->getLogin(),
            'motDePasse' => $agent->getMotDePasse(),
            'roleAgent' => $agent->getRole(),
            'idService' => $idServiceAgent->getNomService(),
            'idGuichet' => $guichetAgent->getNomGuichet(),
            'estActif' => $agent->getEstActif(),
            'idServiceAgent' => $idServiceAgent->getIdService(),
            'idGuichetAgent' => $guichetAgent->getIdGuichet()
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }


    public static function supprimerAgentAdministration()
    {
        $res = (new AgentRepository())->supprimer($_REQUEST["idAgent"]);
        if (!$res) {
            header('Content-Type: application/json');
            echo json_encode(['failed' => false, 'message' => 'Erreur lors de la suppression du service.']);
            exit;
        }

        $pusher = new PusherAgent();
        $pusher->trigger('agent-channel', 'agent-supprime', ['idAgent' => $_REQUEST['idAgent']]);
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}

