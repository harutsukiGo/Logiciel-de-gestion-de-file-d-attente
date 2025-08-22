<?php

namespace App\file\Controleur;

use App\file\Configuration\Guichet\PusherGuichet;
use App\file\Modele\DataObject\Guichets;
use App\file\Modele\Repository\GuichetsRepository;
use App\file\Modele\Repository\ServiceRepository;
use Pusher\Pusher;

class ControleurGuichet extends ControleurGenerique
{

    public static function recupererListeGuichet()
    {
        echo json_encode((new GuichetsRepository())->recupererGuichetsActif());
    }

    public static function afficherGuichetsAdministration()
    {
        ControleurAccueil::afficherVue('vueGenerale.php', ["titre" => "Liste des guichets - Adminisitration", "cheminCorpsVue" => "Guichet/listeGuichetsAdministration.php", "guichets" => (new GuichetsRepository())->recupererGuichet()]);

    }

    public static function creerGuichetAdministration()
    {
        $nomGuichet = $_POST["nom_guichet"];
        $statut = $_POST["statutGuichet"] ? 1 : 0;
        $idService = (new ServiceRepository())->recupererParClePrimaire($_POST["idService"]);

        $guichet = new Guichets(null, $nomGuichet, $statut, $idService, 1);

        $guichetCree=(new GuichetsRepository())->ajouterAutoIncrement($guichet);
        $liste=(new GuichetsRepository())->recupererAgentGuichet($guichetCree->getIdGuichet());

        $pusher = new PusherGuichet();
        $pusher->trigger('guichet-channel','guichet-cree',[
            'idGuichet' => $guichetCree->getIdGuichet(),
            'nomGuichet' => $guichetCree->getNomGuichet(),
            'statutGuichet' => $guichetCree->getStatutGuichet(),
            'nomService' => $idService->getNomService(),
            '$listeAgent' => $liste,
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    public static function mettreAJourGuichetAdministration(){
        $idGuichet=$_POST["idGuichet"];
        $nomGuichet = htmlspecialchars($_POST["nom_guichet"]);
        $statut = $_POST["statutGuichet"] ? 1 : 0;
        $idService = (new ServiceRepository())->recupererParClePrimaire($_POST["idService"]);

        $guichet= new Guichets($idGuichet, $nomGuichet, $statut, $idService, 1);

        (new GuichetsRepository())->mettreAJour($guichet);

        $listeAgent=(new GuichetsRepository())->recupererAgentGuichet($guichet->getIdGuichet());

        $pusher = new PusherGuichet();
        $pusher->trigger('guichet-channel','guichet-modifiee',[
            'idGuichet' => $guichet->getIdGuichet(),
            'nomGuichet' => $guichet->getNomGuichet(),
            'statutGuichet' => $guichet->getStatutGuichet(),
            'nomService' => $idService->getNomService(),
            'listeAgent' => $listeAgent,
            'idServiceGuichet' => $idService->getIdService(),
        ]);
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    public static function supprimerGuichetAdministration()
    {
        (new GuichetsRepository())->supprimer($_REQUEST["idGuichet"]);
        $pusher = new PusherGuichet();
        $pusher->trigger('guichet-channel','guichet-supprime',[
            'idGuichet' => $_REQUEST["idGuichet"]]);
    }
}