<?php

namespace App\file\Controleur;

use App\file\Configuration\Service\PusherService;
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

        $s = new Service(null, $nomService, $dateOuverture, $dateFermeture, $statut, 1);

        $service = (new ServiceRepository())->ajouterAutoIncrement($s);

        if (!$service) {
            header('Content-Type: application/json');
            echo json_encode(['failed' => false, 'message' => 'Erreur lors de la création du service.']);
            exit;
        }

        $pusher = new PusherService();
        $pusher->trigger('service-channel', 'service-cree', [
            'idService' => $service->getIdService(),
            'nomService' => $service->getNomService(),
            'horaireDebut' => $service->getHoraireDebut()->format('H:i'),
            'horaireFin' => $service->getHoraireFin()->format('H:i'),
            'statutService' => $service->getStatutService(),
            'estActif' => $service->getEstActif()
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true,]
        );
        exit;
    }

    public static function recupererServicesTableau()
    {
       echo json_encode((new ServiceRepository())->recupererServices());
    }

    public static function mettreAJourServiceAdministration()
    {
        $idService = $_POST['idService'];
        $nomService = $_POST['nomService'];
        $dateOuverture = new \DateTime($_POST['horaireDebut']);
        $dateFermeture = new \DateTime($_POST['horaireFin']);
        $statut = $_POST['statutService'] ? 1 : 0;

        $s = new Service($idService, $nomService, $dateOuverture, $dateFermeture, $statut, 1);

       $res = (new ServiceRepository())->mettreAJour($s);

       if ($res){
           $pusher = new PusherService();
           $pusher->trigger('service-channel', 'service-modifiee', [
               'idService' => $s->getIdService(),
               'nomService' => $s->getNomService(),
               'horaireDebut' => $s->getHoraireDebut()->format('H:i'),
               'horaireFin' => $s->getHoraireFin()->format('H:i'),
               'statutService' => $s->getStatutService(),
               'estActif' => $s->getEstActif()
           ]);
       }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    public static function supprimerServiceAdministration()
    {
       $res= (new ServiceRepository())->supprimer($_REQUEST['idService']);
       if (!$res) {
            header('Content-Type: application/json');
            echo json_encode(['failed' => false, 'message' => 'Erreur lors de la suppression du service.']);
            exit;
       }

        $pusher = new PusherService();
        $pusher->trigger('service-channel', 'service-supprime', ['idService' => $_REQUEST['idService']]);
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}