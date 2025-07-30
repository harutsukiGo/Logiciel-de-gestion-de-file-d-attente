<?php

namespace App\file\Controleur;

use App\file\Modele\DataObject\Avoir;
use App\file\Modele\DataObject\Service;
use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\AvoirRepository;
use App\file\Modele\Repository\GuichetsRepository;
use App\file\Modele\Repository\ServiceRepository;

class ControleurService extends ControleurGenerique
{
    public static function afficherService()
    {
        $services = (new ServiceRepository())->recuperer();
        ControleurService::afficherVue('vueGenerale.php', ["titre" => "Liste des services", "cheminCorpsVue" => "Service/liste.php", "services" => $services]);
    }

    public static function afficherDetail()
    {
        ControleurService::afficherVue('vueGenerale.php', ["titre" => "Création d'un Ticket", "cheminCorpsVue" => "Service/vueDetail.php", "service" => $_REQUEST['idService']]);
    }

    public static function afficherServiceAdministration()
    {
        ControleurService::afficherVue('vueGenerale.php',
            ["titre" => "Liste des services - Administration",
                "cheminCorpsVue" => "Service/listeServiceAdministration.php",
                "services" => (new ServiceRepository())->recuperer()]);
    }

    public static function creerServiceAdministration()
    {
        $nomService = $_POST['nomService'];
        $dateOuverture = new \DateTime($_POST['horaireDebut']);
        $dateFermeture = new \DateTime($_POST['horaireFin']);
        $statut = $_POST['statutService'] ? 1 : 0;

         $s = new Service(null, $nomService, $dateOuverture, $dateFermeture, $statut);

        $service=(new ServiceRepository())->ajouterAutoIncrement($s);

        if (!$service) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du service.']);
            exit;
        }
        $guichet=(new GuichetsRepository())->recupererParClePrimaire((new ControleurService())->recupereGuichet());
        $avoir = new Avoir(null,$service,$guichet);

        (new AvoirRepository())->ajouter($avoir);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
     }

    public static function recupereGuichet()
    {
        $guichet = (new GuichetsRepository())->recuperer();

        if (empty($guichet)) {
            return null;
        }

        $randomIndex = random_int(0, count($guichet) - 1);
        return $guichet[$randomIndex]->getIdGuichet();
    }

     public static function mettreAJourServiceAdministration()
     {
         $idService = $_POST['idService'];
         $nomService = $_POST['nomService'];
         $dateOuverture = new \DateTime($_POST['horaireDebut']);
         $dateFermeture = new \DateTime($_POST['horaireFin']);
         $statut = $_POST['statutService'] ? 1 : 0;

         $s = new Service($idService, $nomService, $dateOuverture, $dateFermeture, $statut);

         (new ServiceRepository())->mettreAJour($s);

         header('Content-Type: application/json');
         echo json_encode(['success' => true]);
         exit;
     }

     public static function supprimerServiceAdministration(){
         (new ServiceRepository())->supprimer($_REQUEST['idService']);
         header('Content-Type: application/json');
         echo json_encode(['success' => true]);
         exit;
     }
}