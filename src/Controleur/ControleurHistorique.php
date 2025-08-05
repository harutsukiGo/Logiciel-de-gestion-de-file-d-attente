<?php
namespace App\file\Controleur;

use App\file\Modele\Repository\HistoriqueRepository;

class ControleurHistorique extends ControleurGenerique
{
    public static function mettreAJourStatutIdHistorique()
    {
        (new HistoriqueRepository())->mettreAJourStatutHistorique($_REQUEST["idHistorique"], $_REQUEST["statut"]);
    }
}