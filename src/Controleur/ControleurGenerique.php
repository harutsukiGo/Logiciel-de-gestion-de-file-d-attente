<?php
namespace App\file\Controleur;

class ControleurGenerique{

    public static function afficherVue(string $cheminVue, array $parametres = []): void{
        extract($parametres);
        require __DIR__ . "/../Vue/$cheminVue";
    }

    public static function redirectionVersURL(string $url):void {
        header("Location: $url");
        exit();
    }

}