<?php

namespace App\file\Controleur;

use App\file\Lib\ConnexionUtilisateur;
use App\file\Modele\HTTP\Cookie;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\HistoriqueRepository;

class ControleurAgent extends ControleurGenerique
{
    public function afficherAgent()
    {
        $historique = (new HistoriqueRepository())->recupererHistoriqueParAgent($_REQUEST["idAgent"]);
        $tickets = (new AgentRepository())->afficherFileAttente($_REQUEST["idAgent"]);
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Interface Agent",
            "cheminCorpsVue" => "Agent/vueInterfaceAgent.php", "agent" => (new AgentRepository())->recupererParClePrimaire($_REQUEST["idAgent"]), "tickets" => $tickets, "historique" => $historique
        ]);
    }

    public function mettreAJourStatutAgent()
    {
        (new AgentRepository())->mettreAJourStatut($_REQUEST["idAgent"], $_REQUEST["statut"]);
    }

    public function recupereTicketAgent()
    {
        $ticketAgent = (new AgentRepository())->retournePlusPetitTicketAgent();
        header('Content-Type: application/json');
        echo json_encode($ticketAgent);
    }

    public function recupererFileAttente()
    {
        (new AgentRepository())->afficherFileAttente($_REQUEST["idAgent"]);
    }

    public function afficherAuthentification()
    {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Authentification Agent",
            "cheminCorpsVue" => "Agent/vueAuthentification.php"
        ]);
    }



    public function connecter()
    {

        if (!isset($_REQUEST['login']) && !isset($_REQUEST['motDePasse'])) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }
//
        $agent = (new AgentRepository())->recupererParLogin($_REQUEST['login']);
             if (is_null($agent)) {
            ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
            return;
        }
//
//        if (!VerificationEmail::aValideEmail($utilisateur)) {
//            MessageFlash::ajouter("warning", "vous n'avez pas valider votre email");
//            ControleurUtilisateur::redirectionVersURL("?action=afficherListe&controleur=utilisateur");
//            return;
//        }
//
        if (!$_REQUEST['motDePasse'] == $agent->getMotDePasse()) {
             ControleurAgent::redirectionVersURL("?action=afficherAuthentification&controleur=agent");
        }
         ConnexionUtilisateur::connecter($agent->getIdAgent());
         ControleurAgent::redirectionVersURL("?action=afficherDetail&controleur=agent&idAgent=" . $agent->getIdAgent());
    }


    public function afficherDetail()
    {
         ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Détail Agent",
            "cheminCorpsVue" => "Agent/vueDetail.php",
            "agent" =>  (new AgentRepository())->recupererParClePrimaire($_REQUEST['idAgent'])]);
    }

    public static function deconnecter()
    {
        ConnexionUtilisateur::deconnecter();
//        MessageFlash::ajouter("info", "utilisateur deconnecter");
        ControleurAgent::redirectionVersURL("?action=afficherAccueil&controleur=accueil");
    }


    public function test()
    {

    }
}

