<?php
namespace App\file\Controleur;
use App\file\Modele\Repository\ClientAttentesRepository;

class ControleurClientAttentes extends ControleurGenerique
{
    public static function mettreAJourServiceClient()
    {
      (new ClientAttentesRepository())->mettreAJourService($_REQUEST["idTicket"], $_REQUEST["idService"]);
    }
}