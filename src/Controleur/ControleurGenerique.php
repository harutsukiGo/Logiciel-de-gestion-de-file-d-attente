<?php
namespace App\file\Controleur;

use App\file\Lib\PreferenceControleur;

class ControleurGenerique{

    public static function afficherVue(string $cheminVue, array $parametres = []): void{
        extract($parametres);
        require __DIR__ . "/../Vue/$cheminVue";
    }


    public static function enregistrerPreference()
    {
        if (isset($_REQUEST['controleur_defaut'])) {
            PreferenceControleur::enregistrer($_REQUEST['controleur_defaut']);
             ControleurAccueil::redirectionVersURL("?action=afficherAccueil");
        }
    }
    public static function redirectionVersURL(string $url):void {
        header("Location: $url");
        exit();
    }

}