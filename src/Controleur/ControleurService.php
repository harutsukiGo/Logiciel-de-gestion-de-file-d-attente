<?php

namespace App\file\Controleur;

use App\file\Modele\Repository\ServiceRepository;

class ControleurService extends ControleurGenerique
{
    public function afficherService()
    {
        $services = (new ServiceRepository())->recuperer();
        ControleurService::afficherVue('vueGenerale.php', ["titre" => "Liste des services", "cheminCorpsVue" => "Service/liste.php", "services" => $services]);
    }

    public function afficherDetail()
    {
        ControleurService::afficherVue('vueGenerale.php', ["titre" => "Création d'un Ticket", "cheminCorpsVue" => "Service/vueDetail.php", "service" => $_REQUEST['idService']]);
    }


}