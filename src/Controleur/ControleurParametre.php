<?php

namespace App\file\Controleur;

use App\file\Modele\DataObject\Parametres;
use App\file\Modele\Repository\ParametresRepository;


class ControleurParametre extends ControleurGenerique
{
    public static function afficherParametre()
    {
        ControleurService::afficherVue('vueGenerale.php', ["titre" => "Paramètres", "cheminCorpsVue" => "Parametre/vueParametre.php"]);
    }

    public static function mettreAJourParametres()
    {
        $nomOrganisation = $_POST["nom_organisation"];
        $ouverture = (string)$_POST["heure_ouverture"];
        $fermeture = (string)$_POST["heure_fermeture"];

        $parametreNomOrganisation = (new ParametresRepository())->getValeur("nom_organisation");
        $parametreOuveture = (new ParametresRepository())->getValeur("heure_ouverture");
        $parametreFermeture = (new ParametresRepository())->getValeur("heure_fermeture");

        $parametreAJourFermeture = new Parametres($parametreFermeture->getIdParametre(), "heure_fermeture", $fermeture);
        $parametreAJourOuverture = new Parametres($parametreOuveture->getIdParametre(), "heure_ouverture", $ouverture);
        $parametreAJourNomOrganisation = new Parametres($parametreNomOrganisation->getIdParametre(), "nom_organisation", $nomOrganisation);

        (new ParametresRepository())->mettreAJour($parametreAJourFermeture);
        (new ParametresRepository())->mettreAJour($parametreAJourNomOrganisation);
        (new ParametresRepository())->mettreAJour($parametreAJourOuverture);

        header('Content-Type: application/json');
        echo json_encode(['success' => true,]
        );
        exit;
    }
}