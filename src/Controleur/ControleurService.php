<?php

namespace App\file\Controleur;

use App\file\Modele\DataObject\Service;
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

        (new ServiceRepository())->ajouter($s);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
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
}