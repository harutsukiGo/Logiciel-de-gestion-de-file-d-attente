<?php
namespace App\file\Controleur;

class ControleurParametre extends ControleurGenerique{
    public static function afficherParametre()
    {
        ControleurService::afficherVue('vueGenerale.php', ["titre" => "Paramètres", "cheminCorpsVue" => "Parametre/vueParametre.php"]);
    }
}