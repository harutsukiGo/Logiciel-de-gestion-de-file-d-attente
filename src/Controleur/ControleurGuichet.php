<?php

namespace App\file\Controleur;

use App\file\Modele\DataObject\Guichets;
use App\file\Modele\Repository\GuichetsRepository;
use App\file\Modele\Repository\ServiceRepository;

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
        $nomGuichet = htmlspecialchars($_POST["nom_guichet"]);
        $statut = $_POST["statutGuichet"] ? 1 : 0;
        $idService = (new ServiceRepository())->recupererParClePrimaire($_POST["idService"]);

        $guichet = new Guichets(null, $nomGuichet, $statut, $idService, 1);

        (new GuichetsRepository())->ajouter($guichet);

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

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    public static function supprimerGuichetAdministration()
    {
        (new GuichetsRepository())->supprimerGuichet();
    }
}