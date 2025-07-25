<?php
namespace App\file\Controleur;

class ControleurAccueil extends ControleurGenerique
{
    public static function afficherAccueil(): void
    {
        ControleurAccueil::afficherVue('vueGenerale.php', ["titre" => "Accueil", "cheminCorpsVue" => "vueAccueil.php"]);
    }


}
