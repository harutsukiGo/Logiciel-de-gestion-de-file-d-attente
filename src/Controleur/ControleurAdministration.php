<?php
namespace App\file\Controleur;


use App\file\Modele\Repository\AgentRepository;
use App\file\Modele\Repository\ServiceRepository;

class ControleurAdministration extends ControleurGenerique
{
    public static function afficherAdministration()
    {
        $agents= (new AgentRepository())->recuperer();
        $services= (new ServiceRepository())->recuperer();
        ControleurGenerique::afficherVue('vueGenerale.php', [
            "titre" => "Interface Administration",
            "cheminCorpsVue" => "Administration/vueAdministration.php","services" => $services,"agents" => $agents
        ]);
    }


}